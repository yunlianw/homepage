<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/VERSION.php';

session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$pdo = getDB();
$CTX = get_full_context($pdo);
$article_count = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$recent = $pdo->query("SELECT id,title,type,add_time FROM articles ORDER BY id DESC LIMIT 5")->fetchAll();
$generated = is_file(ROOT_PATH . '/index.html');

echo render('admin/layout', [
    'page' => 'index',
    'title' => '仪表盘',
    'page_title' => '仪表盘',
    'content' => render('admin/dashboard', [
        'article_count' => $article_count,
        'recent' => $recent,
        'generated' => $generated,
        'site_name' => $CTX['basic']['name'] ?? '个人主页',
        'active_theme' => $CTX['system']['theme_id'] ?? 'default_bento',
        'msg' => $_GET['msg'] ?? ''
    ])
]);
