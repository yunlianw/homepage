<?php
/**
 * 静态页面生成器 v2 - 全能适配协议
 * 特性：错误捕获、权限检查、状态回传、缓存清理、$CTX全量注入
 */
class StaticGenerator {
    private PDO $pdo;
    private array $errors = [];
    private array $warnings = [];

    public function __construct() {
        $this->pdo = getDB();
    }

    /**
     * 获取完整上下文（数据总线核心）
     */
    private function getCTX(): array {
        return get_full_context($this->pdo);
    }

    /**
     * 检查目录写入权限
     */
    private function checkWritable(string $dir, string $label): bool {
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0755, true)) {
                $this->errors[] = "目录创建失败: {$label} ({$dir})";
                return false;
            }
            $this->warnings[] = "已创建目录: {$label} ({$dir})";
        }
        if (!is_writable($dir)) {
            $this->errors[] = "目录无写入权限: {$label} ({$dir})";
            return false;
        }
        return true;
    }

    /**
     * 检查模板文件是否存在
     */
    private function checkTemplate(string $theme, string $template): bool {
        $file = THEME_DIR . '/' . $theme . '/' . $template . '.php';
        if (!file_exists($file)) {
            $this->errors[] = "模板文件不存在: {$theme}/{$template}.php";
            return false;
        }
        return true;
    }

    /**
     * 生成所有页面（主入口）
     */
    public function generateAll(bool $clearCache = false): array {
        $logs = [];
        $this->errors = [];
        $this->warnings = [];

        try {
            // 1. 数据准备
            $CTX = $this->getCTX();
            $theme = $CTX['system']['theme_id'] ?? 'default_bento';
            $postsSlug = $CTX['system']['posts_slug'] ?? 'posts';

            $logs[] = ['type' => 'info', 'msg' => "主题: {$theme} | 文章目录: /{$postsSlug}"];

            // 2. 模板文件检查
            if (!$this->checkTemplate($theme, 'index')) {
                throw new Exception(implode('; ', $this->errors));
            }
            if (!$this->checkTemplate($theme, 'article')) {
                throw new Exception(implode('; ', $this->errors));
            }

            // 3. 目录权限检查
            $postsDir = ROOT_PATH . '/' . $postsSlug;
            if (!$this->checkWritable(ROOT_PATH, '根目录')) {
                throw new Exception(implode('; ', $this->errors));
            }
            if (!$this->checkWritable($postsDir, '文章目录')) {
                throw new Exception(implode('; ', $this->errors));
            }

            // 4. 可选：清理旧文件
            if ($clearCache) {
                $this->clearStaticFiles(ROOT_PATH, $postsSlug);
                $logs[] = ['type' => 'info', 'msg' => '已清理旧静态文件'];
            }

            // 5. 文章数据
            $articles = $this->pdo->query("SELECT * FROM articles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
            $postsUrl = '/' . $postsSlug;

            // 6. 数据注入 - 统一 $CTX + 辅助变量
            $data = [
                'CTX'       => $CTX,
                'articles'  => $articles,
                'posts_url' => $postsUrl,
                'posts_slug' => $postsSlug,
            ];
            
            // Favicon注入
            $faviconHtml = '';
            $faviconUrl = $CTX['seo']['favicon'] ?? '';
            if (!empty($faviconUrl)) {
                $faviconHtml = '<link rel="icon" type="image/png" sizes="32x32" href="' . h($faviconUrl) . '">';
                // 如果是ico格式
                if (pathinfo($faviconUrl, PATHINFO_EXTENSION) === 'ico') {
                    $faviconHtml = '<link rel="icon" type="image/x-icon" href="' . h($faviconUrl) . '">';
                }
                // SVG
                if (pathinfo($faviconUrl, PATHINFO_EXTENSION) === 'svg') {
                    $faviconHtml = '<link rel="icon" type="image/svg+xml" href="' . h($faviconUrl) . '">';
                }
            }

            // 全局插件注入（音乐播放器等）
            $globalPlugins = render_global_music($CTX['system'] ?? []);

            // 天气数据注入（服务端预取）
            $weatherCfg = $CTX['system']['weather'] ?? [];
            if (!empty($weatherCfg['enabled']) && !empty($weatherCfg['city'])) {
                $globalPlugins .= "\n" . render_weather_widget($weatherCfg['city']);
            }

            // 7. 生成主页
            ob_start();
            $indexContent = renderTheme('index', $data);
            ob_end_clean();
            if (empty($indexContent)) {
                throw new Exception('主页生成结果为空，模板可能有PHP错误');
            }
            // 注入favicon到 </head> 前
            if ($faviconHtml && strpos($indexContent, '</head>') !== false) {
                $indexContent = str_replace('</head>', $faviconHtml . "\n</head>", $indexContent);
            }
            // 注入全局插件到 </body> 前
            if ($globalPlugins && strpos($indexContent, '</body>') !== false) {
                $indexContent = str_replace('</body>', $globalPlugins . "\n</body>", $indexContent);
            }
            $written = file_put_contents(ROOT_PATH . '/index.html', $indexContent);
            if ($written === false) {
                throw new Exception('index.html 写入失败，请检查根目录权限');
            }
            $logs[] = ['type' => 'ok', 'msg' => "✓ index.html 已生成 [主题: {$theme}, " . number_format($written) . " bytes]"];

            // 8. 生成文章详情页
            foreach ($articles as $article) {
                $data['article'] = $article;
                ob_start();
                $content = renderTheme('article', $data);
                ob_end_clean();
                if (empty($content)) {
                    $logs[] = ['type' => 'err', 'msg' => "✗ {$postsSlug}/{$article['id']}.html 生成结果为空"];
                    continue;
                }
                // 注入favicon
                if ($faviconHtml && strpos($content, '</head>') !== false) {
                    $content = str_replace('</head>', $faviconHtml . "\n</head>", $content);
                }
                // 注入全局插件
                if ($globalPlugins && strpos($content, '</body>') !== false) {
                    $content = str_replace('</body>', $globalPlugins . "\n</body>", $content);
                }
                $written = file_put_contents($postsDir . '/' . $article['id'] . '.html', $content);
                if ($written === false) {
                    $logs[] = ['type' => 'err', 'msg' => "✗ {$postsSlug}/{$article['id']}.html 写入失败"];
                    continue;
                }
                $logs[] = ['type' => 'ok', 'msg' => "✓ {$postsSlug}/{$article['id']}.html 已生成"];
            }

            // 9. 添加警告信息
            foreach ($this->warnings as $w) {
                $logs[] = ['type' => 'warn', 'msg' => '⚠ ' . $w];
            }

            $name = $CTX['basic']['name'] ?? '主页';
            $logs[] = ['type' => 'ok', 'msg' => "✓ 共生成 {$name} + " . count($articles) . ' 个文章页'];

        } catch (Exception $e) {
            foreach ($this->errors as $err) {
                $logs[] = ['type' => 'err', 'msg' => '✗ ' . $err];
            }
            $logs[] = ['type' => 'err', 'msg' => '✗ 生成失败: ' . $e->getMessage()];
            $logs[] = ['type' => 'err', 'msg' => '✗ 文件: ' . $e->getFile() . ':' . $e->getLine()];
            return ['success' => false, 'logs' => $logs];
        }

        return ['success' => true, 'logs' => $logs];
    }

    /**
     * 清理旧的静态文件
     */
    private function clearStaticFiles(string $rootDir, string $postsSlug): void {
        // 清理主页
        if (file_exists($rootDir . '/index.html')) {
            @unlink($rootDir . '/index.html');
        }
        // 清理文章页
        $postsDir = $rootDir . '/' . $postsSlug;
        if (is_dir($postsDir)) {
            $files = glob($postsDir . '/*.html');
            if ($files) {
                foreach ($files as $f) {
                    @unlink($f);
                }
            }
        }
    }
}
