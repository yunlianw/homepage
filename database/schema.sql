-- 个人主页展示系统 - 数据库结构
-- 版本: v1.1.0
-- 日期: 2026-05-11
-- 导入: mysql -u root -p 数据库名 < schema.sql

CREATE TABLE IF NOT EXISTS `config_data` (
  `id` int(11) NOT NULL DEFAULT '1',
  `basic_json` text COMMENT '基本信息JSON',
  `hero_stats_json` text COMMENT '统计数据JSON',
  `social_json` text COMMENT '社交链接JSON',
  `list_data_json` text COMMENT '列表数据JSON',
  `hobby_json` text COMMENT '兴趣爱好JSON',
  `system_json` text COMMENT '系统配置JSON',
  `blocks_json` text COMMENT '板块开关JSON',
  `seo_json` text COMMENT 'SEO配置JSON',
  `ext_json` text COMMENT '扩展配置JSON',
  `icp` varchar(100) DEFAULT NULL COMMENT '备案号',
  `copyright` varchar(255) DEFAULT NULL COMMENT '版权信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='站点配置数据';

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `summary` varchar(500) DEFAULT NULL COMMENT '摘要',
  `cover_image` varchar(500) DEFAULT NULL COMMENT '封面图',
  `tags` varchar(255) DEFAULT NULL COMMENT '标签',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态: 1发布 0草稿',
  `sort_order` int(11) DEFAULT '0' COMMENT '排序',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章/动态表';

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL COMMENT '管理员用户名',
  `password` varchar(255) NOT NULL COMMENT '密码(bcrypt hash)',
  `admin_dir` varchar(50) NOT NULL DEFAULT 'admin' COMMENT '后台目录名',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

-- 初始管理员账号（密码: admin888）
INSERT INTO `admin_users` (`id`, `username`, `password`, `admin_dir`) VALUES
(1, 'admin', '$2y$10$default_hash_replace_me', 'admin');

-- 初始配置数据
INSERT INTO `config_data` (`id`, `basic_json`, `system_json`) VALUES
(1, '{}', '{"theme_id":"default_bento"}');
