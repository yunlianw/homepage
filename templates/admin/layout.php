<?php if(!defined('APP_VERSION')) require_once ROOT_PATH . '/config/VERSION.php'; ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$title ?? '后台管理'?></title>
<link href="<?=SITE_URL?>/assets/css/admin.css" rel="stylesheet">
<?php if(!empty($extra_css)):?><style><?=$extra_css?></style><?php endif;?>
</head>
<body>
<div class="layout">
<aside>
    <h2>🐄 <?=$site_name ?? SITE_NAME?></h2>
    <small>后台管理系统</small>
    <nav>
        <a href="index.php" <?=$page==='index'?'class="on"':''?>>📊 仪表盘</a>
        <a href="config.php" <?=$page==='config'?'class="on"':''?>>⚙️ 资料配置</a>
        <a href="articles.php" <?=$page==='articles'?'class="on"':''?>>📝 动态管理</a>
        <a href="generate.php">🚀 一键生成</a>
        <a href="settings.php" <?=$page==='settings'?'class="on"':''?>>🔐 管理员设置</a>
    </nav>
</aside>
<main>
<header>
    <h1><?=$page_title ?? '后台管理'?> <small style="color:var(--muted);font-size:12px"><?=APP_VERSION?></small></h1>
    <a class="logout" href="logout.php">退出登录</a>
</header>
<?=$content ?? ''?>
</main>
</div>
<?php if(!empty($extra_js)):?><script><?=$extra_js?></script><?php endif;?>
</body>
</html>