<?php
/**
 * 静态页生成控制器
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Generator.php';

session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$generator = new StaticGenerator();
$result = $generator->generateAll();

echo render('admin/layout', [
    'page' => 'generate',
    'title' => '生成静态页',
    'page_title' => '生成静态页',
    'content' => render('admin/generate_result', $result)
]);