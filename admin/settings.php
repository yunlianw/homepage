<?php
/**
 * 后台设置 - 修改密码、修改后台目录
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';

session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$msg = '';
$msgType = 'err';

// 获取当前管理员信息
$admin = $pdo->query("SELECT * FROM admin_users WHERE id=1")->fetch(PDO::FETCH_ASSOC);

// ============ 修改密码 ============
if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $oldPwd = $_POST['old_password'] ?? '';
    $newPwd = $_POST['new_password'] ?? '';
    $cfmPwd = $_POST['cfm_password'] ?? '';

    if (empty($oldPwd) || empty($newPwd) || empty($cfmPwd)) {
        $msg = '请填写所有字段';
    } elseif (!password_verify($oldPwd, $admin['password'])) {
        $msg = '原密码错误';
    } elseif (mb_strlen($newPwd) < 6) {
        $msg = '新密码至少6个字符';
    } elseif ($newPwd !== $cfmPwd) {
        $msg = '两次输入的新密码不一致';
    } else {
        $hash = password_hash($newPwd, PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE admin_users SET password=?, username=? WHERE id=1")
            ->execute([$hash, $_POST['new_username'] ?? $admin['username']]);
        $msg = '密码修改成功';
        $msgType = 'ok';
        $admin = $pdo->query("SELECT * FROM admin_users WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    }
}

// ============ 修改后台目录 ============
if (isset($_POST['action']) && $_POST['action'] === 'change_dir') {
    $newDir = trim($_POST['new_dir'] ?? '');
    $currentDir = $admin['admin_dir'];

    if (empty($newDir)) {
        $msg = '目录名不能为空';
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $newDir)) {
        $msg = '目录名只允许字母、数字、下划线和横线';
    } elseif ($newDir === $currentDir) {
        $msg = '新目录名与当前相同';
    } elseif (is_dir(ROOT_PATH . '/' . $newDir)) {
        $msg = '该目录名已存在，请换一个';
    } else {
        $oldPath = ROOT_PATH . '/' . $currentDir;
        $newPath = ROOT_PATH . '/' . $newDir;

        // 备份
        $backupFile = ROOT_PATH . '/admin_dir_backup_' . date('Ymd_His') . '.json';
        file_put_contents($backupFile, json_encode([
            'from' => $currentDir,
            'to' => $newDir,
            'time' => date('Y-m-d H:i:s')
        ], JSON_PRETTY_PRINT));

        // 重命名目录
        if (rename($oldPath, $newPath)) {
            // 更新数据库
            $pdo->prepare("UPDATE admin_users SET admin_dir=? WHERE id=1")->execute([$newDir]);
            $admin['admin_dir'] = $newDir;
            $msg = "后台目录已修改为: {$newDir}\n\n⚠️ 重要提示：\n1. 新后台地址: " . SITE_URL . "/{$newDir}/login.php\n2. 请立即记录此地址\n3. 当前页面将跳转到新地址";
            $msgType = 'ok';

            // 跳转到新地址
            header("Refresh: 3; url=../{$newDir}/settings.php");
        } else {
            $msg = '目录重命名失败，请检查权限';
        }
    }
}

echo render('admin/layout', [
    'page' => 'settings',
    'title' => '系统设置',
    'content' => render('admin/settings_form', [
        'msg' => $msg,
        'msgType' => $msgType,
        'admin' => $admin,
    ])
]);