-- MySQL dump 10.13  Distrib 5.7.44, for Linux (x86_64)
--
-- Host: localhost    Database: gerenzhuye
-- ------------------------------------------------------
-- Server version	5.7.44-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config_data`
--

DROP TABLE IF EXISTS `config_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_data`
--

LOCK TABLES `config_data` WRITE;
/*!40000 ALTER TABLE `config_data` DISABLE KEYS */;
INSERT INTO `config_data` VALUES (1,'{\"name\":\"峰哥\",\"job_title\":\"产品运营 · 独立开发者 · 终身学习者\",\"bio_summary\":\"热衷于用技术和设计解决真实问题，相信「少即是多」。白天做产品，夜晚炒美股，周末去远方。喜欢记录生活里的微小美好，也喜欢和不同的人交流想法。\",\"avatar_url\":\"\",\"photo_wall\":[],\"video_url\":\"\",\"cover_image\":\"\",\"motto\":\"做正确的事，而不是容易的事。\",\"location\":\"上海，中国\",\"hero_tags\":[\"产品设计\",\"PHP\",\"数据分析\",\"摄影\",\"烹饪\",\"骑行\"],\"status_tags\":[\"📍 上海\",\"✈ 旅行中\",\"⌨ 开源贡献\"],\"now_text\":\"试正在思考如何用 AI 让笔记真正有用，而不是让人更焦虑。\"}','{\"cities\":\"70\",\"projects\":\"6\",\"years\":\"11\"}','{\"email\":\"hi@zhangyuanming.com\",\"github\":\"https:\\/\\/shop.5276.net\\/\",\"weibo\":\"https:\\/\\/shop.5276.net\\/\",\"bilibili\":\"https:\\/\\/shop.5276.net\\/\"}','{\"skills\":{\"产品设计\":90,\"数据分析\":75,\"摄影\":70,\"烹饪\":65,\"冥想\":60,\"骑行\":75},\"projects\":[{\"name\":\"🔮 MindWeave — AI 知识图谱\",\"desc\":\"将笔记自动构建成可探索的思维网络\",\"url\":\"#\",\"tags\":[{\"text\":\"上线中\",\"color\":\"g\"},{\"text\":\"Swift\",\"color\":\"b\"},{\"text\":\"Python\",\"color\":\"b\"}]},{\"name\":\"📊 MarketLens — 市场速览\",\"desc\":\"实时聚合多平台投资情绪与数据\",\"url\":\"#\",\"tags\":[{\"text\":\"开发中\",\"color\":\"a\"},{\"text\":\"React\",\"color\":\"b\"},{\"text\":\"FastAPI\",\"color\":\"b\"}]},{\"name\":\"✍️ 无干扰写作平台\",\"desc\":\"极简写作 + AI 辅助润色\",\"url\":\"#\",\"tags\":[{\"text\":\"已上线\",\"color\":\"g\"},{\"text\":\"Next.js\",\"color\":\"b\"}]}],\"travel\":[{\"place\":\"🇯🇵 日本\",\"date\":\"2024年6月\",\"status\":\"done\"},{\"place\":\"大理 丽江\",\"date\":\"2023年5月\",\"status\":\"done\"},{\"place\":\"海口 三亚\",\"date\":\"2025年3月\",\"status\":\"done\"},{\"place\":\"东北 抚远\",\"date\":\"2026年7月\",\"status\":\"plan\"}],\"experience\":[],\"services\":[]}','{\"investment\":{\"returns\":\"+18.4%\",\"total\":\"\",\"allocations\":[{\"name\":\"A股权益\",\"pct\":38,\"color\":\"var(--bar1)\"},{\"name\":\"美股ETF\",\"pct\":30,\"color\":\"var(--bar2)\"},{\"name\":\"债券基金\",\"pct\":20,\"color\":\"var(--bar3)\"},{\"name\":\"加密资产\",\"pct\":12,\"color\":\"var(--bar4)\"}]},\"media\":[{\"icon\":\"📗\",\"title\":\"被讨厌的勇气\",\"sub\":\"岸见一郎 · 阿德勒心理学\",\"progress\":72,\"bg\":\"var(--amber-dim)\"},{\"icon\":\"🎬\",\"title\":\"The Brutalist\",\"sub\":\"2024 · 历史剧情 · ★★★★½\",\"progress\":0,\"bg\":\"var(--blue-dim)\"},{\"icon\":\"🎵\",\"title\":\"汪峰 — 美丽世界的孤儿\",\"sub\":\"新摇滚 · 今日播放 23次\",\"progress\":0,\"bg\":\"var(--green-dim)\"}]}','{\"theme_id\":\"default_bento\",\"posts_slug\":\"posts\",\"music\":{\"enabled\":true,\"autoplay\":true,\"playlist\":[{\"title\":\"美丽世界的孤儿\",\"url\":\"\\/assets\\/music\\/wangfeng.mp3\"},{\"title\":\"汪峰-存在\",\"url\":\"\\/assets\\/music\\/cunzai.mp3\"}]},\"custom_header\":\"\",\"custom_footer\":\"\",\"weather\":{\"enabled\":true,\"city\":\"Shanghai\"},\"ext\":[]}','{\"title\":\"峰哥- 产品运营 & 独立开发者\",\"keywords\":\"产品运营 ,独立开发者,Python,Swift\",\"description\":\"热衷于用技术和设计解决真实问题的产品经理与独立开发者\",\"favicon\":\"\\/assets\\/images\\/favicon_1778564364.png\"}','[]','{\"about\":\"1\",\"now\":\"1\",\"activity\":\"1\",\"travel\":\"1\",\"projects\":\"1\",\"invest\":\"1\",\"media\":\"1\",\"contact\":\"1\"}','','© 2026 峰哥· Built with ❤️','2026-05-11 09:14:41','2026-05-12 05:39:29');
/*!40000 ALTER TABLE `config_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_dir` varchar(50) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$12$r3U7XSV2Lyy2PXw9cS85GefqXQI6OrtHVYPyOERqvbDlbDEHReily','admin','2026-05-11 13:30:30','2026-05-11 13:30:30');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `summary` varchar(500) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'dynamic',
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'完成了个人主页系统','用PHP+MySQL搭建了一套轻量级个人主页系统','<p>今天完成了一套轻量级个人主页展示系统的开发。</p><p>主要功能包括：</p><ul><li>后台管理配置</li><li>动态文章发布</li><li>一键生成静态页面</li></ul>','tech','2026-05-11 00:50:00');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-12 15:11:20
