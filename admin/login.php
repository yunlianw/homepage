<?php
/**
 * 后台登录控制器
 * 优先从数据库读取管理员信息，兼容config.php硬编码
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';

session_start();

// 从数据库获取管理员信息
$adminUser = ADMIN_USER;
$adminPass = ADMIN_PASS;

try {
    $pdo = getDB();
    $row = $pdo->query("SELECT * FROM admin_users WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $adminUser = $row['username'];
        // 数据库存的是hash，用password_verify
        $adminHash = $row['password'];
    }
} catch (Exception $e) {
    // 数据库异常时降级到config.php
    $adminHash = null;
}

$error = '';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];

    $loginOk = false;
    if (isset($adminHash) && !empty($adminHash)) {
        // 数据库验证（hash）
        if ($inputUser === $adminUser && password_verify($inputPass, $adminHash)) {
            $loginOk = true;
        }
    } else {
        // config.php降级验证（明文）
        if ($inputUser === $adminUser && $inputPass === $adminPass) {
            $loginOk = true;
        }
    }

    if ($loginOk) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    }
    $error = '用户名或密码错误';
}

if (!empty($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

echo render('admin/login', [
    'title' => '后台登录',
    'error' => $error
]);