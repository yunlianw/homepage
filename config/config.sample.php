<?php
/**
 * 站点基础设置
 * 首次安装请修改以下配置
 */

// ============ 管理员账号 ============
// 默认密码: admin888（首次登录后请立即修改）
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin888');

// ============ 站点URL ============
// 改成你的域名（带 https://）
define('SITE_URL', 'https://your-domain.com');

// ============ 数据库配置 ============
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');

// ============ 路径配置（一般不用改） ============
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_URL', SITE_URL . '/assets');
define('SITE_NAME', '个人主页系统');
define('THEME_DIR', ROOT_PATH . '/themes');
define('ADMIN_TEMPLATE_DIR', ROOT_PATH . '/templates');