<?php
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$config = [
    'name' => $B['name'] ?? '',
];
$siteUrl = '/';
?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=h($article['title']??'文章详情')?> - <?=h($B['name']??'')?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/themes/apple_dark/style.css">
</head>
<body>
<button class="theme-toggle" onclick="toggleTheme()" title="切换主题">
    <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
    <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
</button>
<div class="container">
    <div class="grid">
        <div class="card" style="grid-column: span 2; padding: 48px 36px;">
            <div class="card-header">
                <span class="card-title"><?=h($article['icon']??'📝')?> <?=h($article['type']??'动态')?></span>
            </div>
            <h1 style="font-size: 28px; font-weight: 600; margin: 20px 0 12px; color: var(--text-primary);"><?=h($article['title']??'')?></h1>
            <div style="color: var(--text-tertiary); font-size: 14px; margin-bottom: 28px;"><?=h($article['add_time']??'')?></div>
            <div style="color: var(--text-secondary); line-height: 1.8; font-size: 15px;"><?=$article['content']??''?></div>
            <a href="<?=$siteUrl?>" class="link-item" style="display: inline-flex; margin-top: 32px; padding: 10px 20px; border: 1px solid var(--border-subtle); border-radius: 12px; text-decoration: none; color: var(--text-primary);">
                <svg style="width:18px;height:18px;margin-right:8px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                返回主页
            </a>
        </div>
    </div>
</div>
<script>
function toggleTheme(){const e=document.documentElement,t=e.getAttribute("data-theme"),n="dark"===t?"light":"dark";e.setAttribute("data-theme",n),localStorage.setItem("theme",n)}
document.addEventListener("DOMContentLoaded",function(){const e=localStorage.getItem("theme");e&&document.documentElement.setAttribute("data-theme",e)});
</script>
</body>
</html>