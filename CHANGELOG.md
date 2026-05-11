# 个人主页展示系统 - 更新日志

## v1.1.0 (2026-05-11)

### 🎵 音乐播放器系统

**新增功能**
- 全局音乐播放器（MiniPlayer类）
- 播放列表支持（多首歌曲切换）
- 上一首/下一首控制
- 进度条拖动跳转
- 播放列表弹窗（☰按钮）
- localStorage 记忆进度、歌曲序号、播放状态
- 页面跳转后自动恢复播放进度
- 自动播放（需用户首次交互后）

**后台配置**
- 音乐配置Tab：启用开关、自动播放、播放列表
- 播放列表格式：`标题|URL`（每行一首）
- 支持本地MP3文件（`assets/music/`目录）

**技术实现**
- `assets/js/player.js` - MiniPlayer类
- `assets/css/player.css` - 播放器样式
- `render_global_music()` - Generator自动注入到所有页面
- 浏览器autoplay政策兼容（用户交互后播放）

### 🌤 天气显示系统

**新增功能**
- 服务端预取天气数据（wttr.in免费接口）
- 无需客户端API请求
- 支持任意城市（中文/拼音）
- 生成时写入HTML，零延迟

**后台配置**
- 系统Tab → 天气显示配置
- 启用开关、城市名设置

**技术实现**
- `render_weather_widget()` - 服务端预取函数
- `<script id="weather-data">` - JSON注入
- 模板JS读取并显示

### 🔐 后台管理增强

**新增功能**
- 管理员设置页面（`admin/settings.php`）
- 修改密码（原密码验证 + 二次确认）
- 修改用户名
- 修改后台目录名（自动rename + 跳转）
- 修改记录自动备份

**数据库**
- 新增 `admin_users` 表
- 字段：id, username, password(hash), admin_dir, created_at, updated_at
- 登录验证改用 bcrypt hash

**安全增强**
- 密码不再是明文存储
- 支持修改后台访问路径
- 原密码验证机制

### 🔧 扩展系统

**新增功能**
- ext_json 万能扩展字段
- 后台「扩展」Tab
- Key-Value 表单，随意增减
- 模板调用：`$SYS['ext']['your_key']`

**使用场景**
- 自定义按钮文案
- 导航项目配置
- 公司名称
- 任意模板特有参数

### 🎨 模板优化

**tech_minimal**
- 全动态模板重构
- 导航从 ext 读取
- 所有板块条件判断
- 天气卡片集成
- 修复 location 显示

**apple_dark**
- 添加 $CTX 兼容层
- 动态列表改为 foreach
- 项目列表动态渲染
- 文章链接可点击
- 移除所有硬编码默认值

**default_bento**
- 移除播放器重复代码
- 统一使用全局注入

### 📦 其他改进

**新增字段**
- `basic_json.location` - 位置/城市
- `system_json.weather` - 天气配置
- `system_json.ext` - 扩展配置

**Generator v2**
- try-catch 错误捕获
- 权限检查
- 模板存在性检查
- 双层输出缓冲

---

## v1.0.0 (2026-05-11)

### 初始版本发布

**系统功能**
- 版本号管理：`config/VERSION.php` 统一管理
- 版本号格式：`v主版本.次版本.修订号`

**主题系统**
- 创建3个主题，完整还原原始模板视觉效果
- default_bento: Bento卡片布局（基于12.html）
- tech_minimal: 玻璃态科技风（基于22.html）
- apple_dark: Apple暗黑风格（基于2026.html）

**后台管理**
- 管理员登录系统
- 站点配置（10个选项卡）
- 文章管理（增删改查）
- 一键生成静态页
- 主题切换

**数据展示**
- Hero区域
- Bento Grid布局
- 旅行足迹
- 项目展示
- 投资记录
- 书影音
- 联系方式

**技术特性**
- 静态页生成
- 主题系统
- 明暗主题切换
- 粒子动画背景
- 响应式设计

### Bug修复

- 修复tech_minimal导航栏错误
- 修复tech_minimal profile卡片数据丢失
- 修复tech_minimal JS null引用错误
- 修复default_bento多出"技能"卡片
- 修复CSS变量格式统一

---

*项目: 个人主页展示系统*
*开发者: 牛马一号 🐮*