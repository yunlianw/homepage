# 个人主页展示系统

[![Version](https://img.shields.io/badge/version-v1.1.0-blue.svg)](CHANGELOG.md)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)

一个简洁优雅的个人主页展示系统，支持多主题切换、音乐播放器、天气显示、静态页生成、后台可视化管理。开箱即用，带安装向导。

## ✨ 特性

- 🎨 **多主题支持** - 内置3个精心设计的主题，可扩展
- 🎵 **音乐播放器** - 全局播放器，播放列表，进度记忆
- 🌤 **天气显示** - 服务端预取，无需API Key
- ⚡ **静态生成** - 一键生成纯静态HTML，极速加载
- 🔐 **后台管理** - 可视化配置，密码修改，目录自定义
- 📱 **响应式设计** - 完美适配各种设备
- 🌙 **明暗主题** - 支持日间/夜间切换
- 🔧 **扩展系统** - ext_json 万能扩展字段
- 🚀 **安装向导** - install.php 一键安装，自动检测域名

## 📦 5分钟上手

```bash
# 1. 下载并解压
wget https://github.com/yunlianw/homepage/releases/download/v1.1.0/personal-homepage-v1.1.0.tar.gz
tar -xzvf personal-homepage-v1.1.0.tar.gz

# 2. 设置权限
chown -R www:www .
chmod -R 755 .
chmod -R 777 posts/ assets/music/ config/

# 3. 访问安装向导
# https://你的域名/install.php
```

详见 [INSTALL.md](INSTALL.md)

## 🎭 内置主题

| 主题 | 风格 | 特点 |
|------|------|------|
| default_bento | Bento卡片 | 温暖米白、粒子背景、瀑布流布局 |
| tech_minimal | 玻璃态科技 | 3D翻书、天气卡片、粒子动画 |
| apple_dark | Apple暗黑 | 网格卡片、流畅动效、Apple风格 |

## 📁 目录结构

```
├── install.php          # 安装向导
├── admin/               # 后台管理
│   ├── login.php        # 登录页
│   ├── settings.php     # 管理员设置
│   ├── config.php       # 站点配置
│   ├── articles.php     # 动态管理
│   └── generate.php     # 一键生成
├── config/
│   ├── config.php       # 主配置（安装后生成）
│   ├── config.sample.php # 配置模板
│   └── VERSION.php      # 版本号
├── core/                # 核心类库
│   ├── db.php           # 数据库连接
│   ├── functions.php    # 通用函数
│   └── Generator.php    # 静态生成器
├── themes/              # 主题目录
│   ├── default_bento/   # Bento卡片主题
│   ├── tech_minimal/    # 科技极简主题
│   └── apple_dark/      # Apple暗黑主题
├── templates/admin/     # 后台模板
├── assets/              # 静态资源
│   ├── css/             # 样式
│   ├── js/              # 脚本
│   └── music/           # 音乐文件目录
├── database/            # 数据库文件
├── posts/               # 生成的文章页
└── index.html           # 生成的首页
```

## 🎵 音乐播放器

- 全局播放器，所有页面通用
- 播放列表（多首歌曲）
- 上一首/下一首/列表弹窗
- localStorage 记忆进度
- 后台配置：`标题|URL` 每行一首
- MP3 文件放 `assets/music/` 目录

## 🌤 天气显示

- wttr.in 免费接口，无需API Key
- 服务端预取，生成时写入HTML
- 后台开启并设置城市即可

## 🔐 安全特性

- bcrypt 密码hash存储
- 可修改后台目录名
- install.lock 防重复安装
- 配置文件不包含在开源包中

## 🛠 环境要求

- PHP >= 7.4（需 pdo_mysql 扩展）
- MySQL >= 5.7
- Nginx / Apache

## 📝 更新日志

详见 [CHANGELOG.md](CHANGELOG.md)

## 📄 许可证

[MIT License](LICENSE)

## 👤 作者

牛马一号 🐮

## 🤝 贡献

欢迎提交 Issue 和 Pull Request！

---

*Made with ❤️ by 牛马一号*