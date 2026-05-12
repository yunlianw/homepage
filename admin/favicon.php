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
        if (empty($_FILES['favicon']) || $_FILES['favicon']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('上传失败');
        }
        
        $file = $_FILES['favicon'];
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception('文件大小不能超过2MB');
        }
        
        $allowedTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/x-icon', 'image/svg+xml'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('只支持 PNG/JPG/GIF/ICO/SVG 格式');
        }
        
        $info = getimagesize($file['tmp_name']);
        if (!$info) {
            throw new Exception('文件不是有效图片');
        }
        
        $ext = 'png';
        if ($info[2] === IMAGETYPE_ICO) $ext = 'ico';
        if ($info[2] === IMAGETYPE_SVG) $ext = 'svg';
        
        $filename = 'favicon_' . time() . '.' . $ext;
        $filepath = $saveDir . '/' . $filename;
        
        if ($info[2] !== IMAGETYPE_ICO && $info[2] !== IMAGETYPE_SVG) {
            $srcImg = null;
            switch ($info[2]) {
                case IMAGETYPE_JPEG: $srcImg = imagecreatefromjpeg($file['tmp_name']); break;
                case IMAGETYPE_PNG:  $srcImg = imagecreatefrompng($file['tmp_name']); break;
                case IMAGETYPE_GIF:  $srcImg = imagecreatefromgif($file['tmp_name']); break;
            }
            if ($srcImg) {
                $dstImg = imagescale($srcImg, 32, 32);
                imagepng($dstImg, $filepath, 9);
                if (PHP_VERSION_ID < 80000) {
                    imagedestroy($srcImg);
                    imagedestroy($dstImg);
                }
            } else {
                move_uploaded_file($file['tmp_name'], $filepath);
            }
        } else {
            move_uploaded_file($file['tmp_name'], $filepath);
        }
        
        echo json_encode(['ok' => true, 'url' => '/assets/images/' . $filename, 'msg' => '上传成功']);
        
    } elseif ($action === 'generate') {
        $text = trim($_POST['text'] ?? '');
        if ($text === '') throw new Exception('请输入文字');
        
        $bgColor = trim($_POST['bgColor'] ?? '#3B82F6');
        $textColor = trim($_POST['textColor'] ?? '#FFFFFF');
        
        // 校验颜色格式
        if (!preg_match('/^#?[0-9a-fA-F]{3,6}$/', $bgColor)) $bgColor = '#3B82F6';
        if (!preg_match('/^#?[0-9a-fA-F]{3,6}$/', $textColor)) $textColor = '#FFFFFF';
        if ($bgColor[0] !== '#') $bgColor = '#' . $bgColor;
        if ($textColor[0] !== '#') $textColor = '#' . $textColor;
        
        $png32 = FaviconGenerator::generate($text, $bgColor, $textColor, 32);
        $png16 = FaviconGenerator::generate($text, $bgColor, $textColor, 16);
        
        $filename = 'favicon_' . time() . '.png';
        file_put_contents($saveDir . '/' . $filename, $png32);
        
        echo json_encode(['ok' => true, 'url' => '/assets/images/' . $filename, 'msg' => '生成成功']);
        
    } elseif ($action === 'preview') {
        $text = trim($_GET['text'] ?? '');
        if ($text === '') throw new Exception('请输入文字');
        
        $bgColor = trim($_GET['bgColor'] ?? '#3B82F6');
        $textColor = trim($_GET['textColor'] ?? '#FFFFFF');
        
        if (!preg_match('/^#?[0-9a-fA-F]{3,6}$/', $bgColor)) $bgColor = '#3B82F6';
        if (!preg_match('/^#?[0-9a-fA-F]{3,6}$/', $textColor)) $textColor = '#FFFFFF';
        if ($bgColor[0] !== '#') $bgColor = '#' . $bgColor;
        if ($textColor[0] !== '#') $textColor = '#' . $textColor;
        
        $png = FaviconGenerator::generate($text, $bgColor, $textColor, 64);
        $base64 = base64_encode($png);
        
        echo json_encode(['ok' => true, 'preview' => 'data:image/png;base64,' . $base64]);
        
    } else {
        echo json_encode(['ok' => false, 'msg' => '未知操作']);
    }
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
}
