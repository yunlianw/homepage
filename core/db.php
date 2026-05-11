<?php
/**
 * 数据库连接 - 从配置文件读取
 * 配置文件：config/config.php
 */
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = defined('DB_HOST') ? DB_HOST : 'localhost';
        $port = defined('DB_PORT') ? DB_PORT : 3306;
        $name = defined('DB_NAME') ? DB_NAME : '';
        $user = defined('DB_USER') ? DB_USER : '';
        $pass = defined('DB_PASS') ? DB_PASS : '';
        
        if (empty($name) || empty($user)) {
            throw new RuntimeException('数据库未配置，请检查 config/config.php');
        }
        
        $pdo = new PDO(
            'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $name . ';charset=utf8mb4',
            $user, $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}
