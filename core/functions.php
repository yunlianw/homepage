<?php
/**
 * 数据总线引擎 - 全能适配协议
 * 将数据库所有JSON字段合并为一个 $CTX 多维数组
 * 模板通过 $CTX['basic']['name'] 方式调用
 */
if (!function_exists('get_full_context')) {
    function get_full_context(PDO $pdo, array $config = []): array {
        if (empty($config)) {
            $config = $pdo->query("SELECT * FROM config_data WHERE id=1")->fetch(PDO::FETCH_ASSOC);
        }

        $j = function($s, $d = []) { return ($s && $s !== '') ? json_decode($s, true) : $d; };

        return [
            'basic'      => $j($config['basic_json'], []),
            'hero_stats'  => $j($config['hero_stats_json'], []),
            'social'     => $j($config['social_json'], []),
            'list'       => $j($config['list_data_json'], []),
            'hobby'      => $j($config['hobby_json'], []),
            'system'     => $j($config['system_json'], []),
            'seo'        => $j($config['seo_json'], []),
            'ext'        => $j($config['ext_json'], []),
            'blocks'     => $j($config['blocks_json'], []),
            'icp'        => $config['icp_info'] ?? '',
            'copyright'  => $config['footer_copyright'] ?? '',
        ];
    }
}

/**
 * 模板渲染函数 - 后台管理模板
 */
if (!function_exists('render')) {
    function render(string $template, array $data = []): string {
        $templateFile = ADMIN_TEMPLATE_DIR . '/' . $template . '.php';
        if (!file_exists($templateFile)) {
            throw new Exception("模板不存在: {$template}");
        }
        ob_start();
        extract($data);
        include $templateFile;
        return ob_get_clean();
    }
}

/**
 * 主题模板渲染 - 公开页面模板
 */
if (!function_exists('renderTheme')) {
    function renderTheme(string $template, array $data = []): string {
        $theme = $data['CTX']['system']['theme_id'] ?? 'default_bento';
        $templateFile = THEME_DIR . '/' . $theme . '/' . $template . '.php';
        if (!file_exists($templateFile)) {
            throw new Exception("主题模板不存在: {$templateFile}");
        }
        // 抑制模板内部的PHP错误输出，捕获到缓冲区
        $prevLevel = error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        ob_start();
        extract($data);
        include $templateFile;
        $output = ob_get_clean();
        error_reporting($prevLevel);
        return $output;
    }
}

/**
 * 安全的HTML转义
 */
if (!function_exists('h')) {
    function h(?string $s): string {
        return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    }
}

/**
 * 安全JSON解码
 */
if (!function_exists('jsonSafe')) {
    function jsonSafe($str, $default = []) {
        $d = json_decode($str ?? '', true);
        return (json_last_error() === JSON_ERROR_NONE) ? $d : $default;
    }
}

/**
 * 安全JSON编码
 */
if (!function_exists('jsonEncode')) {
    function jsonEncode($data): string {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

/**
 * 写入静态文件
 */
if (!function_exists('writeStatic')) {
    function writeStatic(string $filename, string $content, string $dir): void {
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($dir . '/' . $filename, $content);
    }
}

/**
 * 渲染Hero统计（兼容CTX）
 */
if (!function_exists('renderHeroStats')) {
    function renderHeroStats(array $stats): string {
        $labels = [
            'cities'    => ['unit' => ' 城',   'lbl' => '城市足迹'],
            'projects'  => ['unit' => ' 项目', 'lbl' => '已上线'],
            'assets'    => ['num' => '320', 'unit' => '万', 'lbl' => '资产规模'],
            'years'     => ['unit' => ' 年',   'lbl' => '工作年限'],
            'days'      => ['unit' => ' 天',   'lbl' => '运行天数'],
            'followers' => ['unit' => '',       'lbl' => '关注者'],
            'posts'     => ['unit' => ' 篇',   'lbl' => '文章'],
            'views'     => ['unit' => '',       'lbl' => '浏览量'],
        ];
        $html = '';
        foreach ($stats as $key => $val) {
            if ($val === '' || $val === null) continue;
            $info = $labels[$key] ?? ['unit' => '', 'lbl' => $key];
            $num = $info['num'] ?? $val;
            $unit = $info['unit'] ?? '';
            $html .= '<div class="stat"><div class="num">' . h($num) . '<em>' . $unit . '</em></div><div class="lbl">' . h($info['lbl']) . '</div></div>';
        }
        return $html;
    }
}

/**
 * 渲染项目列表（兼容CTX）
 */
if (!function_exists('renderProjects')) {
    function renderProjects(array $projects): string {
        if (empty($projects)) return '<p style="color:var(--text3)">暂无项目</p>';
        $html = '<div class="proj-list">';
        foreach ($projects as $p) {
            $html .= '<div class="proj" onclick="window.open(\'' . h($p['url'] ?? '#') . '\',\'_blank\')">';
            $html .= '<div class="proj-name">' . h($p['name'] ?? '') . '</div>';
            $html .= '<div class="proj-desc">' . h($p['desc'] ?? '') . '</div>';
            if (!empty($p['tags'])) {
                $html .= '<div class="proj-pills">';
                foreach ($p['tags'] as $tag) {
                    $cc = $tag['color'] ?? 'b';
                    $html .= '<span class="ppill ppill-' . $cc . '">' . h($tag['text'] ?? '') . '</span>';
                }
                $html .= '</div>';
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}

/**
 * 渲染旅行足迹（兼容CTX）
 */
if (!function_exists('renderTravel')) {
    function renderTravel(array $travel): string {
        if (empty($travel)) return '';
        $html = '<div class="tmap">';
        $html .= '<svg viewBox="0 0 300 104" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<defs><radialGradient id="gd" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#00d2ff" stop-opacity="0.35"/><stop offset="100%" stop-color="#00d2ff" stop-opacity="0"/></radialGradient>';
        $html .= '<radialGradient id="gl" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="#5b8870" stop-opacity="0.4"/><stop offset="100%" stop-color="#5b8870" stop-opacity="0"/></radialGradient></defs>';
        $html .= '<path d="M20,75 Q60,25 120,50 T200,30 T280,60" stroke="var(--path-color)" stroke-width="1.5" fill="none" stroke-dasharray="4 3"/>';
        $dots = [[25,72],[70,35],[120,48],[170,32],[220,42],[270,55]];
        $cities = ['上海','东京','京都','雷克雅未克','皇后镇','第比利斯'];
        foreach ($dots as $i => $d) {
            $glow = $i % 2 === 0 ? 'gd' : 'gl';
            $html .= '<circle cx="' . $d[0] . '" cy="' . $d[1] . '" r="8" fill="url(#' . $glow . ')"/>';
            $html .= '<circle cx="' . $d[0] . '" cy="' . $d[1] . '" r="3" fill="var(--dot-color)"/>';
            $html .= '<text x="' . $d[0] . '" y="' . ($d[1] + 16) . '" text-anchor="middle" fill="var(--text3)" font-size="7">' . ($cities[$i] ?? '') . '</text>';
        }
        $html .= '</svg></div>';
        return $html;
    }
}

/**
 * 渲染投资记录（兼容CTX）
 */
if (!function_exists('renderInvestment')) {
    function renderInvestment(array $investment): string {
        if (empty($investment)) return '';
        $html = '<div class="inv-grid">';
        $html .= '<div class="inv-card"><div class="inv-val" style="color:var(--green)">' . h($investment['returns'] ?? '') . '</div><div class="inv-lbl">今年收益率</div></div>';
        $html .= '<div class="inv-card"><div class="inv-val">' . h($investment['total'] ?? '') . '</div><div class="inv-lbl">总资产规模</div></div>';
        $html .= '</div>';
        if (!empty($investment['allocations'])) {
            $html .= '<div class="bar-rows">';
            foreach ($investment['allocations'] as $a) {
                $pct = $a['pct'] ?? 0;
                $html .= '<div class="bar-row"><span class="bar-lbl">' . h($a['name'] ?? '') . '</span>';
                $html .= '<div class="bar-track"><div class="bar-fill" data-w="' . $pct . '%" style="background:' . ($a['color'] ?? 'var(--bar1)') . '"></div></div>';
                $html .= '<span class="bar-pct">' . $pct . '%</span></div>';
            }
            $html .= '</div>';
        }
        return $html;
    }
}

/**
 * 渲染书影音（兼容CTX）
 */
if (!function_exists('renderMedia')) {
    function renderMedia(array $media): string {
        if (empty($media)) return '';
        $html = '';
        foreach ($media as $m) {
            $bg = $m['bg'] ?? 'var(--amber-dim)';
            $html .= '<div class="media-item">';
            $html .= '<div class="mcov" style="background:' . $bg . '">' . h($m['icon'] ?? '') . '</div>';
            $html .= '<div><div class="mttl">' . h($m['title'] ?? '') . '</div>';
            $html .= '<div class="msub">' . h($m['sub'] ?? '') . '</div>';
            if (!empty($m['progress'])) {
                $html .= '<div class="mprog"><div class="mprog-fill" style="width:' . $m['progress'] . '%"></div></div>';
            }
            $html .= '</div></div>';
        }
        return $html;
    }
}

/**
 * 渲染社交链接（兼容CTX）
 */
if (!function_exists('renderSocial')) {
    function renderSocial(array $social): array {
        $icons = ['email' => ['✉','var(--accent-dim)','var(--accent)'], 'github' => ['⌨','var(--sep)','var(--text)'], 'weibo' => ['微','var(--amber-dim)','var(--amber)'], 'bilibili' => ['B','var(--accent2-dim)','var(--accent2)'], 'twitter' => ['🐦','var(--blue-dim)','var(--blue)'], 'telegram' => ['✈','var(--blue-dim)','var(--blue)'], 'phone' => ['📞','var(--green-dim)','var(--green)'], 'location' => ['📍','var(--amber-dim)','var(--amber)']];
        $links = [];
        foreach ($social as $key => $val) {
            if (empty($val) || $key === 'wechat_qrcode') continue;
            $ic = $icons[$key] ?? ['🔗','var(--sep)','var(--text)'];
            $href = (strpos($key, 'http') === 0 || strpos($val, 'http') === 0) ? $val : $val;
            if ($key === 'email') $href = 'mailto:' . $val;
            $links[] = ['icon' => $ic[0], 'bg' => $ic[1], 'color' => $ic[2], 'href' => $href, 'text' => $val];
        }
        return $links;
    }
}

/**
 * 获取文章动态样式
 */
if (!function_exists('getArticleStyle')) {
    function getArticleStyle(?string $type): array {
        $styles = [
            'run' => ['icon' => '🏃', 'bg' => 'var(--green-dim)'],
            'idea' => ['icon' => '💡', 'bg' => 'var(--blue-dim)'],
            'photo' => ['icon' => '📷', 'bg' => 'var(--amber-dim)'],
            'food' => ['icon' => '🍜', 'bg' => 'var(--accent2-dim)'],
            'code' => ['icon' => '⌨', 'bg' => 'var(--blue-dim)'],
            'default' => ['icon' => '💬', 'bg' => 'var(--accent-dim)'],
        ];
        return $styles[$type] ?? $styles['default'];
    }
}

/**
 * 获取社交平台样式
 */
if (!function_exists('getSocialStyle')) {
    function getSocialStyle(string $key): array {
        $styles = [
            'email' => ['icon' => '✉', 'bg' => 'var(--accent-dim)', 'color' => 'var(--accent)'],
            'github' => ['icon' => '⌨', 'bg' => 'var(--sep)', 'color' => 'var(--text)'],
            'weibo' => ['icon' => '微', 'bg' => 'var(--amber-dim)', 'color' => 'var(--amber)'],
            'bilibili' => ['icon' => 'B', 'bg' => 'var(--accent2-dim)', 'color' => 'var(--accent2)'],
            'twitter' => ['icon' => '🐦', 'bg' => 'var(--blue-dim)', 'color' => 'var(--blue)'],
            'telegram' => ['icon' => '✈', 'bg' => 'var(--blue-dim)', 'color' => 'var(--blue)'],
            'wechat' => ['icon' => '微信', 'bg' => 'var(--green-dim)', 'color' => 'var(--green)'],
            'phone' => ['icon' => '📞', 'bg' => 'var(--green-dim)', 'color' => 'var(--green)'],
            'location' => ['icon' => '📍', 'bg' => 'var(--amber-dim)', 'color' => 'var(--amber)'],
        ];
        return $styles[$key] ?? ['icon' => '🔗', 'bg' => 'var(--sep)', 'color' => 'var(--text)'];
    }
}

/**
 * 全局音乐播放器（系统插件）
 * 从 $CTX['system']['music'] 读取配置，在任何模板下都生效
 */
if (!function_exists('render_global_music')) {
    function render_global_music(array $SYS): string {
        $M = $SYS['music'] ?? [];
        if (empty($M['enabled']) || empty($M['playlist'])) {
            return '';
        }
        $playlist = json_encode($M['playlist'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $autoplay = !empty($M['autoplay']) ? 'true' : 'false';
        
        return <<<HTML
<link href="/assets/css/player.css" rel="stylesheet">
<script src="/assets/js/player.js"></script>
<script>const miniPlayer = new MiniPlayer({playlist:{$playlist},autoplay:{$autoplay}});</script>
HTML;
    }
}

/**
 * 天气数据服务端预取（wttr.in）
 * 生成时直接写入HTML，避免客户端请求
 */
if (!function_exists('render_weather_widget')) {
    function render_weather_widget(string $city): string {
        $url = "https://wttr.in/" . urlencode($city) . "?format=%C|%t|%w|%l";
        $ctx = stream_context_create(['http' => ['timeout' => 3]]);
        $data = @file_get_contents($url, false, $ctx);
        if (!$data) return '<script id="weather-data" type="application/json">{"error":true}</script>';
        
        $parts = explode('|', trim($data));
        $weather = [
            'condition' => $parts[0] ?? 'Unknown',
            'temp' => $parts[1] ?? '--',
            'wind' => $parts[2] ?? '--',
            'location' => $parts[3] ?? $city,
        ];
        return '<script id="weather-data" type="application/json">' . json_encode($weather, JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
