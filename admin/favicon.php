<?php
/**
 * Favicon管理接口
 * 处理上传和文字生成
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/FaviconGenerator.php';

session_start();
if (empty($_SESSION['admin'])) {
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'msg' => '未登录']);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
$action = $_GET['action'] ?? '';

$saveDir = ROOT_PATH . '/assets/images';

try {
    if ($action === 'upload') {
        // 上传favicon
        if (empty($_FILES['favicon']) || $_FILES['favicon']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('上传失败');
        }
        
        $file = $_FILES['favicon'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxSize) {
            throw new Exception('文件大小不能超过2MB');
        }
        
        // 验证类型
        $allowedTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/x-icon', 'image/svg+xml'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('只支持 PNG/JPG/GIF/ICO/SVG 格式');
        }
        
        // 验证是真实图片
        $info = getimagesize($file['tmp_name']);
        if (!$info) {
            throw new Exception('文件不是有效图片');
        }
        
        // 统一转为PNG
        $ext = 'png';
        if ($info[2] === IMAGETYPE_ICO) {
            $ext = 'ico';
        }
        
        // 如果不是ico，转为png
        $filename = 'favicon_' . time() . '.' . $ext;
        $filepath = $saveDir . '/' . $filename;
        
        if ($info[2] !== IMAGETYPE_ICO && $info[2] !== IMAGETYPE_SVG) {
            // 转为PNG
            $srcImg = null;
            switch ($info[2]) {
                case IMAGETYPE_JPEG: $srcImg = imagecreatefromjpeg($file['tmp_name']); break;
                case IMAGETYPE_PNG:  $srcImg = imagecreatefrompng($file['tmp_name']); break;
                case IMAGETYPE_GIF:  $srcImg = imagecreatefromgif($file['tmp_name']); break;
            }
            if ($srcImg) {
                // 缩放到32x32
                $dstImg = imagescale($srcImg, 32, 32);
                imagepng($dstImg, $filepath, 9);
                imagedestroy($srcImg);
                imagedestroy($dstImg);
                $filename = 'favicon_' . time() . '.png';
                $filepath = $saveDir . '/' . $filename;
            } else {
                // 直接保存原文件
                move_uploaded_file($file['tmp_name'], $filepath);
            }
        } else {
            // ICO或SVG直接保存
            move_uploaded_file($file['tmp_name'], $filepath);
        }
        
        $url = '/assets/images/' . $filename;
        echo json_encode(['ok' => true, 'url' => $url, 'msg' => '上传成功']);
        
    } elseif ($action === 'generate') {
        // 文字生成favicon
        $text = trim($_POST['text'] ?? '');
        if ($text === '') {
            throw new Exception('请输入文字');
        }
        
        $color = $_POST['color'] ?? 'blue';
        
        // 生成多个尺寸
        $png32 = FaviconGenerator::generate($text, $color, 32);
        $png16 = FaviconGenerator::generate($text, $color, 16);
        
        $filename = 'favicon_' . time() . '.png';
        file_put_contents($saveDir . '/' . $filename, $png32);
        file_put_contents($saveDir . '/favicon_16_' . time() . '.png', $png16);
        
        $url = '/assets/images/' . $filename;
        echo json_encode(['ok' => true, 'url' => $url, 'msg' => '生成成功']);
        
    } elseif ($action === 'preview') {
        // 预览（不保存，直接输出base64）
        $text = trim($_GET['text'] ?? '');
        if ($text === '') {
            throw new Exception('请输入文字');
        }
        
        $color = $_GET['color'] ?? 'blue';
        $png = FaviconGenerator::generate($text, $color, 64); // 预览用64px
        $base64 = base64_encode($png);
        
        echo json_encode(['ok' => true, 'preview' => 'data:image/png;base64,' . $base64]);
        
    } else {
        echo json_encode(['ok' => false, 'msg' => '未知操作']);
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
}
