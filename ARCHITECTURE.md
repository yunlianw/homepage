# 架构说明 - 个人主页展示系统

## 目录结构

```
cf.5276.net/
├── config/
│   ├── config.php          # 数据库配置（安装时生成config.php）
│   └── VERSION.php         # 版本号管理
├── core/
│   ├── db.php              # 数据库连接
│   ├── functions.php       # 数据总线 + 渲染函数
│   ├── Generator.php       # 静态页面生成器
│   └── FaviconGenerator.php# Favicon生成器（GD库）
├── admin/
│   ├── config.php          # 资料配置控制器
│   ├── generate.php        # 一键生成静态页
│   ├── favicon.php         # Favicon上传/生成接口
│   ├── articles.php        # 文章管理
│   ├── login.php           # 登录
│   ├── logout.php          # 登出
│   ├── settings.php        # 管理员设置
│   └── index.php           # 后台首页
├── templates/
│   └── admin/
│       ├── layout.php      # 后台布局
│       └── config_form.php # 配置表单
├── themes/
│   ├── default_bento/      # Bento卡片主题
│   ├── tech_minimal/       # 玻璃科技主题
│   └── apple_dark/         # Apple暗黑主题
├── assets/
│   ├── css/                # 样式文件
│   ├── js/                 # 脚本文件
│   ├── images/             # 图片资源
│   ├── music/              # 音乐文件
│   └── fonts/              # 字体文件（中文favicon用）
├── install.php             # 安装向导
├── index.html              # 生成的静态主页
├── posts/                  # 生成的文章页
├── database/
│   └── schema.sql          # 数据库表结构
└── CHANGELOG.md            # 更新日志
```

## 数据库

单库设计，核心表：

| 表名 | 说明 |
|------|------|
| config_data | 站点配置（JSON存储） |
| articles | 文章 |
| admin_users | 管理员 |

config_data 使用JSON字段存储所有配置：
- `basic_json` - 基本信息（姓名/头像/标签等）
- `hero_stats_json` - 核心指标
- `social_json` - 社交链接
- `list_data_json` - 技能/项目/旅行
- `hobby_json` - 投资/书影音
- `system_json` - 系统设置（主题/音乐/天气/扩展）
- `seo_json` - SEO（标题/关键词/描述/favicon）
- `ext_json` - 扩展字段
- `blocks_json` - 板块可见性

## 静态生成流程

```
Generator::generateAll()
  ├── 读取数据库 → $CTX（完整上下文）
  ├── 渲染主题模板 → index + article页
  ├── 注入 favicon → </head>前
  ├── 注入音乐播放器 → </body>前
  ├── 注入天气数据 → </body>前
  └── 输出 index.html + posts/*.html
```

## 主题开发

每个主题包含：
- `theme.json` - 主题元信息
- `index.php` - 主页模板（接收$CTX）
- `article.php` - 文章详情模板
- `style.css` - 样式

模板通过 `$CTX['basic']['name']` 等方式读取数据。

## 安装程序

4步安装流程：
1. 环境自检（PHP版本/扩展/权限）
2. 数据库配置（AJAX实时检测）
3. 执行安装（建表+创建管理员+生成配置）
4. 完成（生成install.lock）

## Favicon生成

- 后端：PHP GD库 + DroidSansFallback字体
- 支持中文文字生成
- 背景色/文字色独立设置（hex颜色代码）
- 10种预设配色一键切换
- 也支持上传自定义图标
- 生成结果注入到所有页面的 `<head>` 中
