<?php
/**
 * 个人主页展示系统 - 安装向导
 * 版本: v1.1.0
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$step = intval($_GET['step'] ?? 1);
$error = '';
$success = '';

// 自动检测域名
$autoUrl = '';
if (!empty($_SERVER['HTTP_HOST'])) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    $autoUrl = ($https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
}

// 检查是否已安装
if (file_exists(__DIR__ . '/config/config.php') && file_exists(__DIR__ . '/install.lock')) {
    die('<div style="text-align:center;padding:50px;font-family:sans-serif"><h2>✅ 已安装</h2><p>如需重新安装，请删除 <b>install.lock</b> 文件</p><p><a href="index.html">访问首页</a> | <a href="admin/login.php">进入后台</a></p></div>');
}

// ============ 步骤2: 处理安装 ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 2) {
    $db_host = trim($_POST['db_host'] ?? 'localhost');
    $db_port = intval($_POST['db_port'] ?? 3306) ?: 3306;
    $db_name = trim($_POST['db_name'] ?? '');
    $db_user = trim($_POST['db_user'] ?? '');
    $db_pass = trim($_POST['db_pass'] ?? '');
    $site_url = rtrim(trim($_POST['site_url'] ?? ''), '/');
    $admin_user = trim($_POST['admin_user'] ?? 'admin');
    $admin_pass = trim($_POST['admin_pass'] ?? 'admin888');
    $admin_dir = trim($_POST['admin_dir'] ?? 'admin');

    // 验证
    if (empty($db_name) || empty($db_user)) {
        $error = '请填写数据库信息';
        $step = 1;
    } elseif (empty($site_url)) {
        $error = '请填写站点URL';
        $step = 1;
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $admin_dir)) {
        $error = '后台目录名只能包含字母、数字、下划线和横线';
        $step = 1;
    } else {
        // 测试数据库连接
        try {
            $pdo = new PDO("mysql:host={$db_host};port={$db_port};charset=utf8mb4", $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // 创建数据库（如果不存在）
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARSET utf8mb4");
            $pdo->exec("USE `{$db_name}`");

            // 导入SQL（建表+数据一步到位）
            $demoFile = __DIR__ . '/database/demo.sql';
            if (file_exists($demoFile)) {
                $pdo->exec(file_get_contents($demoFile));
            }

            // 更新管理员密码
            $adminHash = password_hash($admin_pass, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE admin_users SET username=?, password=?, admin_dir=? WHERE id=1")
                ->execute([$admin_user, $adminHash, $admin_dir]);

            // 创建config.php
            $configContent = <<<PHP
<?php
/**
 * 站点基础设置
 * 由安装程序自动生成
 */
define('ADMIN_USER', '{$admin_user}');
define('ADMIN_PASS', '{$admin_pass}');
define('SITE_URL', '{$site_url}');
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_URL', SITE_URL . '/assets');
define('SITE_NAME', '个人主页系统');
define('THEME_DIR', ROOT_PATH . '/themes');
define('ADMIN_TEMPLATE_DIR', ROOT_PATH . '/templates');

// 数据库配置
define('DB_HOST', '{$db_host}');
define('DB_PORT', {$db_port});
define('DB_NAME', '{$db_name}');
define('DB_USER', '{$db_user}');
define('DB_PASS', '{$db_pass}');
PHP;
            file_put_contents(__DIR__ . '/config/config.php', $configContent);

            // 重命名后台目录
            if ($admin_dir !== 'admin' && is_dir(__DIR__ . '/admin')) {
                rename(__DIR__ . '/admin', __DIR__ . '/' . $admin_dir);
            }

            // 创建锁文件
            file_put_contents(__DIR__ . '/install.lock', date('Y-m-d H:i:s'));

            $success = '安装成功！';
            $step = 3;

        } catch (PDOException $e) {
            $error = '数据库错误: ' . $e->getMessage();
            $step = 1;
        } catch (Exception $e) {
            $error = '安装失败: ' . $e->getMessage();
            $step = 1;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安装向导 - 个人主页展示系统 v1.1.0</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .container { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 600px; width: 100%; overflow: hidden; }
        .header { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; padding: 30px; text-align: center; }
        .header h1 { font-size: 24px; margin-bottom: 8px; }
        .header p { opacity: 0.9; font-size: 14px; }
        .content { padding: 30px; }
        .step { display: flex; justify-content: center; gap: 8px; margin-bottom: 30px; }
        .step-dot { width: 32px; height: 32px; border-radius: 50%; background: #e0e0e0; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 600; color: #666; }
        .step-dot.active { background: #667eea; color: #fff; }
        .step-dot.done { background: #4caf50; color: #fff; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #333; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.2s; }
        .form-group input:focus { outline: none; border-color: #667eea; }
        .form-group .hint { font-size: 12px; color: #888; margin-top: 4px; }
        .form-section { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .form-section h3 { font-size: 16px; color: #333; margin-bottom: 15px; }
        .btn { width: 100%; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
        .error { background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
        .success { background: #e8f5e9; color: #2e7d32; padding: 20px; border-radius: 8px; text-align: center; }
        .success h2 { margin-bottom: 10px; }
        .success a { color: #667eea; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        @media (max-width: 500px) { .row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐄 个人主页展示系统</h1>
            <p>安装向导 v1.1.0</p>
        </div>
        <div class="content">
            <div class="step">
                <div class="step-dot <?= $step >= 1 ? ($step > 1 ? 'done' : 'active') : '' ?>">1</div>
                <div class="step-dot <?= $step >= 2 ? ($step > 2 ? 'done' : 'active') : '' ?>">2</div>
                <div class="step-dot <?= $step >= 3 ? 'active' : '' ?>">3</div>
            </div>

            <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($step === 1): ?>
            <form method="post" action="?step=2">
                <div class="form-section">
                    <h3>📦 数据库配置</h3>
                    <div class="row">
                        <div class="form-group">
                            <label>数据库地址</label>
                            <input type="text" name="db_host" value="localhost" placeholder="localhost">
                        </div>
                        <div class="form-group">
                            <label>数据库端口</label>
                            <input type="text" name="db_port" value="3306" placeholder="3306">
                            <div class="hint">默认3306，改过端口请填写</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>数据库名 *</label>
                            <input type="text" name="db_name" placeholder="homepage" required>
                        </div>
                        <div class="form-group">
                            <label>数据库用户 *</label>
                            <input type="text" name="db_user" placeholder="root" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>数据库密码</label>
                        <input type="password" name="db_pass" placeholder="留空表示无密码">
                    </div>
                </div>

                <div class="form-section">
                    <h3>🌐 站点配置</h3>
                    <div class="form-group">
                        <label>站点URL *</label>
                        <input type="text" name="site_url" value="<?= htmlspecialchars($autoUrl) ?>" placeholder="https://your-domain.com" required>
                        <div class="hint">自动检测，如不正确请手动修改</div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>🔐 管理员配置（可选）</h3>
                    <div class="row">
                        <div class="form-group">
                            <label>管理员用户名</label>
                            <input type="text" name="admin_user" value="admin" placeholder="admin">
                        </div>
                        <div class="form-group">
                            <label>管理员密码</label>
                            <input type="password" name="admin_pass" value="admin888" placeholder="admin888">
                            <div class="hint">默认: admin888</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>后台目录名</label>
                        <input type="text" name="admin_dir" value="admin" placeholder="admin">
                        <div class="hint">默认: admin（可改成 yunlian、manage 等）</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">🚀 开始安装</button>
            </form>

            <?php elseif ($step === 3): ?>
            <div class="success">
                <h2>✅ 安装完成！</h2>
                <p style="margin-bottom: 15px;">您的个人主页系统已成功安装</p>
                <p><strong>后台地址：</strong><?= htmlspecialchars($site_url) ?>/<?= htmlspecialchars($admin_dir) ?>/login.php</p>
                <p><strong>管理员：</strong><?= htmlspecialchars($admin_user) ?></p>
                <p style="margin-bottom: 20px;"><strong>密码：</strong><?= htmlspecialchars($admin_pass) ?></p>
                <p>
                    <a href="index.html">访问首页</a> &nbsp;|&nbsp;
                    <a href="<?= htmlspecialchars($admin_dir) ?>/login.php">进入后台</a>
                </p>
            </div>

            <?php endif; ?>
        </div>
    </div>
</body>
</html>