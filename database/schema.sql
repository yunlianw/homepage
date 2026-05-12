-- 个人主页展示系统 - 数据库结构
-- 版本: v1.2.3
-- 日期: 2026-05-12
-- 说明: 纯净建表，无初始数据（数据由demo.sql导入）

CREATE TABLE IF NOT EXISTS `config_data` (
  `id` int(11) NOT NULL DEFAULT '1',
  `basic_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_stats_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_data_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hobby_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocks_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icp_info` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `footer_copyright` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='站点配置数据';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章/动态表';

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL COMMENT '管理员用户名',
  `password` varchar(255) NOT NULL COMMENT '密码(bcrypt hash)',
  `admin_dir` varchar(50) NOT NULL DEFAULT 'admin' COMMENT '后台目录名',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理员表';