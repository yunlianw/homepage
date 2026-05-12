# 二次开发指南

## 目录

- [系统架构](#系统架构)
- [数据结构](#数据结构)
- [主题开发](#主题开发)
- [全局插件开发](#全局插件开发)
- [后台扩展](#后台扩展)
- [数据库字段说明](#数据库字段说明)
- [常用函数](#常用函数)

---

## 系统架构

```
用户访问 → Nginx → index.html（静态页，极速加载）
                    ↑
             Generator.php 生成
                    ↑
             themes/主题/index.php 渲染
                    ↑
             get_full_context() 数据总线
                    ↑
             config_data 表 → basic_json/system_json/...
```

### 核心文件

| 文件 | 说明 |
|------|------|
| `core/db.php` | 数据库连接（PDO） |
| `core/functions.php` | 通用函数、模板渲染、全局插件 |
| `core/Generator.php` | 静态生成器（首页+文章页） |
| `config/config.php` | 站点配置（安装后生成） |
| `config/VERSION.php` | 版本号 |

### 数据流

```
MySQL config_data 表
    ↓ get_full_context($pdo)
$CTX 数组（数据总线）
    ↓ renderTheme('index', ['CTX' => $CTX, ...])
主题模板 index.php
    ↓ ob_start() / ob_get_clean()
HTML字符串
    ↓ Generator 写入文件
index.html
```

---

## 数据结构

### $CTX 数据总线

`get_full_context()` 返回一个数组，所有数据通过 `$CTX` 传给模板：

```php
$CTX = [
    'basic'      => [],  // 基本信息
    'hero_stats' => [],  // 统计数据（KV格式）
    'social'     => [],  // 社交链接（KV格式）
    'list'       => [],  // 列表数据
    'hobby'      => [],  // 兴趣爱好
    'system'     => [],  // 系统配置
    'blocks'     => [],  // 板块开关
    'seo'        => [],  // SEO配置
    'icp'        => '',  // 备案号
    'copyright'  => '',  // 版权信息
];
```

### 模板内使用

每个模板文件顶部添加兼容层：

```php
<?php
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$H = $CTX['hobby'] ?? [];
$L = $CTX['list'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$STATS = $CTX['hero_stats'] ?? [];
$BLOCKS = $CTX['blocks'] ?? [];
?>
```

---

## 主题开发

### 创建新主题

1. **创建目录**

```bash
mkdir -p themes/my_theme
```

2. **必需文件**

```
themes/my_theme/
├── index.php       # 首页模板（必需）
├── article.php     # 文章详情模板（必需）
├── style.css       # 主题样式
├── main.js         # 主题脚本
└── theme.json      # 主题信息（可选）
```

3. **theme.json 配置**

```json
{
    "name": "我的主题",
    "version": "1.0.0",
    "author": "你的名字",
    "description": "主题描述",
    "preview": "预览图URL"
}
```

### index.php 模板结构

```php
<?php
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$H = $CTX['hobby'] ?? [];
$L = $CTX['list'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$STATS = $CTX['hero_stats'] ?? [];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=h($B['name'] ?? '个人主页')?></title>
    <link rel="stylesheet" href="/themes/my_theme/style.css">
</head>
<body>
    <!-- Hero 区域 -->
    <h1><?=h($B['name'] ?? '')?></h1>
    <p><?=h($B['bio_summary'] ?? '')?></p>

    <!-- 项目列表（条件渲染） -->
    <?php if(!empty($L['projects'])): ?>
    <section>
        <h2>项目作品</h2>
        <?php foreach($L['projects'] as $proj): ?>
        <div class="project">
            <h3><?=h($proj['name'] ?? '')?></h3>
            <p><?=h($proj['desc'] ?? '')?></p>
        </div>
        <?php endforeach;?>
    </section>
    <?php endif;?>

    <!-- 文章列表 -->
    <?php if(!empty($articles)): ?>
    <section>
        <?php foreach($articles as $art): ?>
        <a href="<?=$posts_url?>/<?=h($art['id'])?>.html"><?=h($art['title'])?></a>
        <?php endforeach;?>
    </section>
    <?php endif;?>

    <!-- 社交链接 -->
    <?php foreach($S as $k => $v): if(!empty($v)): ?>
    <a href="<?=h($v)?>"><?=h($k)?></a>
    <?php endif; endforeach;?>
</body>
</html>
```

### article.php 文章模板

```php
<?php
// 可用变量：$article（文章数据）、$B、$SYS、$posts_url
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=h($article['title'] ?? '文章')?> - <?=h($B['name'] ?? '')?></title>
    <link rel="stylesheet" href="/themes/my_theme/style.css">
</head>
<body>
    <article>
        <h1><?=h($article['title'])?></h1>
        <time><?=h($article['add_time'])?></time>
        <div class="content"><?=$article['content'] ?? ''?></div>
        <a href="<?=$posts_url?>/../index.html">返回首页</a>
    </article>
</body>
</html>
```

### 可用变量

| 变量 | 说明 | 示例 |
|------|------|------|
| `$B['name']` | 姓名 | 张三 |
| `$B['job_title']` | 职位 | 前端工程师 |
| `$B['bio_summary']` | 简介 | ... |
| `$B['avatar_url']` | 头像URL | ... |
| `$B['motto']` | 座右铭 | ... |
| `$B['now_text']` | 此刻状态 | ... |
| `$B['location']` | 位置 | 上海，中国 |
| `$B['hero_tags']` | 技能标签 | ['PHP', 'Vue'] |
| `$B['status_tags']` | 状态标签 | ['📍 上海', '✈ 旅行中'] |
| `$B['photo_wall']` | 照片墙URL数组 | ['url1', 'url2'] |
| `$B['video_url']` | 展示视频URL | ... |
| `$B['cover_image']` | 封面图URL | ... |
| `$STATS` | 统计数据KV | ['cities'=>'47', 'projects'=>'12'] |
| `$S` | 社交链接KV | ['github'=>'https://...'] |
| `$L['skills']` | 技能列表 | [['name'=>'PHP','pct'=>90]] |
| `$L['projects']` | 项目列表 | [['name'=>'...','desc'=>'...','tags'=>[]]] |
| `$L['travel']` | 旅行记录 | [['place'=>'...','date'=>'...']] |
| `$L['experience']` | 经历列表 | [['company'=>'...','role'=>'...']] |
| `$L['services']` | 服务列表 | [['name'=>'...','desc'=>'...']] |
| `$H['media']` | 书影音 | [['title'=>'...','sub'=>'...','progress'=>80]] |
| `$H['investment']` | 投资记录 | ['total'=>'320万','returns'=>'+18.4%'] |
| `$SYS['music']` | 音乐配置 | ['enabled'=>true,'playlist'=>[]] |
| `$SYS['weather']` | 天气配置 | ['enabled'=>true,'city'=>'Shanghai'] |
| `$SYS['ext']` | 扩展配置 | KV自定义字段 |
| `$articles` | 文章数组 | 从数据库读取 |
| `$posts_url` | 文章目录URL | /posts |
| `$BLOCKS` | 板块开关 | ['projects'=>true,'travel'=>true] |

### 条件渲染

后台没填的栏目应该完全隐藏：

```php
<?php if(!empty($L['projects']) && ($BLOCKS['projects'] ?? true)): ?>
<!-- 项目板块 -->
<?php endif;?>

<?php if(!empty($H['media']) && ($BLOCKS['media'] ?? true)): ?>
<!-- 书影音板块 -->
<?php endif;?>
```

---

## 全局插件开发

全局插件在 `core/functions.php` 中定义，由 `Generator.php` 自动注入到所有页面的 `</body>` 前。

### 现有插件

| 插件 | 函数 | 说明 |
|------|------|------|
| 音乐播放器 | `render_global_music($SYS)` | 全局播放器 |
| 天气数据 | `render_weather_widget($city)` | 服务端天气预取 |

### 开发新插件

1. 在 `core/functions.php` 添加函数：

```php
if (!function_exists('render_my_plugin')) {
    function render_my_plugin(): string {
        return '<script>console.log("hello")</script>';
    }
}
```

2. 在 `core/Generator.php` 的插件注入处调用：

```php
$globalPlugins .= "\n" . render_my_plugin();
```

3. 生成的HTML会自动包含插件代码

### 插件规范

- 函数名用 `render_` 前缀
- 用 `if (!function_exists())` 包裹防止重复定义
- 返回 HTML 字符串
- 不要依赖特定主题的DOM结构

---

## 后台扩展

### 添加新的配置Tab

1. 在 `templates/admin/config_form.php` 添加Tab按钮：

```php
<button type="button" class="<?=$tab==='my_tab'?'on':''?>" data-tab="my_tab" onclick="switchTab('my_tab')">我的配置</button>
```

2. 添加表单内容：

```php
<div id="my_tab" class="section <?=$tab==='my_tab'?'show':''?>">
    <div class="field">
        <label>我的字段</label>
        <input name="my_field" value="<?=h($myValue)?>">
    </div>
</div>
```

3. 在 `admin/config.php` 添加保存逻辑

### 使用 ext_json 扩展字段

后台「扩展」Tab 支持任意 KV 配置：

```
模板调用：<?=h($SYS['ext']['my_key'] ?? '默认值')?>
```

适合模板特有的少量配置，无需改代码。

---

## 数据库字段说明

### config_data 表

| 字段 | 类型 | 说明 |
|------|------|------|
| `basic_json` | TEXT | 基本信息（JSON） |
| `hero_stats_json` | TEXT | 统计数据（JSON KV） |
| `social_json` | TEXT | 社交链接（JSON KV） |
| `list_data_json` | TEXT | 列表数据（JSON） |
| `hobby_json` | TEXT | 兴趣爱好（JSON） |
| `system_json` | TEXT | 系统配置（JSON） |
| `blocks_json` | TEXT | 板块开关（JSON） |
| `seo_json` | TEXT | SEO配置（JSON） |
| `icp` | VARCHAR | 备案号 |
| `copyright` | VARCHAR | 版权信息 |

### basic_json 结构

```json
{
    "name": "姓名",
    "job_title": "职位",
    "bio_summary": "简介",
    "avatar_url": "头像URL",
    "motto": "座右铭",
    "now_text": "此刻状态",
    "location": "位置",
    "hero_tags": ["标签1", "标签2"],
    "status_tags": ["📍 上海"],
    "photo_wall": ["URL1", "URL2"],
    "video_url": "视频URL",
    "cover_image": "封面URL"
}
```

### list_data_json 结构

```json
{
    "skills": [{"name": "PHP", "pct": 90}],
    "projects": [{"name": "项目", "desc": "描述", "url": "#", "tags": [{"text": "标签"}]}],
    "travel": [{"place": "城市", "date": "2024-01", "status": "done"}],
    "experience": [{"company": "公司", "role": "职位", "period": "2020-2024", "desc": "描述"}],
    "services": [{"name": "服务", "desc": "描述"}]
}
```

### hobby_json 结构

```json
{
    "media": [{"title": "书名", "sub": "副标题", "progress": 80, "bg": "#color"}],
    "investment": {
        "total": "320万",
        "returns": "+18.4%",
        "allocations": [{"name": "A股", "pct": 40, "color": "#f00"}]
    }
}
```

### system_json 结构

```json
{
    "theme_id": "default_bento",
    "posts_slug": "posts",
    "music": {"enabled": true, "autoplay": true, "playlist": [{"title": "歌名", "url": "/assets/music/xxx.mp3"}]},
    "weather": {"enabled": true, "city": "Shanghai"},
    "custom_header": "",
    "custom_footer": "",
    "ext": {"btn_projects": "查看项目", "company": "公司名"}
}
```

---

## 常用函数

| 函数 | 说明 |
|------|------|
| `h($str)` | HTML转义（htmlspecialchars） |
| `getDB()` | 获取PDO实例 |
| `get_full_context($pdo)` | 获取完整数据总线 |
| `renderTheme($name, $data)` | 渲染主题模板 |
| `render($template, $data)` | 渲染后台模板 |
| `render_global_music($SYS)` | 渲染音乐播放器 |
| `render_weather_widget($city)` | 渲染天气数据 |

---

## 注意事项

1. **禁止硬编码**：模板中所有文字从 `$CTX` 读取
2. **条件渲染**：后台没填的栏目用 `if(!empty())` 隐藏
3. **路径使用绝对路径**：`/themes/xxx/style.css` 而非相对路径
4. **CSS/JS 放主题目录**：不要依赖外部CDN
5. **函数防重复**：用 `if (!function_exists())` 包裹
6. **代码规范**：单文件不超过400行，模块化分层