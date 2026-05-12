# 安装指南

## 快速安装（推荐）

### 1. 上传文件

将 `personal-homepage-v1.1.0.tar.gz` 上传到网站目录，解压：

```bash
tar -xzvf personal-homepage-v1.1.0.tar.gz
```

### 2. 设置权限

```bash
chown -R www:www .
chmod -R 755 .
chmod -R 777 posts/ assets/music/ config/
```

### 3. 访问安装向导

浏览器打开：
```
https://你的域名/install.php
```

### 4. 填写信息

安装向导会自动检测域名，只需填写：

| 项目 | 说明 | 必填 |
|------|------|------|
| 数据库地址 | 默认 localhost | ✅ |
| 数据库名 | 如 homepage | ✅ |
| 数据库用户 | 如 root | ✅ |
| 数据库密码 | 数据库密码 | - |
| 站点URL | 自动检测 | ✅ |
| 管理员用户名 | 默认 admin | - |
| 管理员密码 | 安装时自定义 | - |
| 后台目录名 | 默认 admin | - |

### 5. 点击安装

一键完成：
- ✅ 自动创建数据库
- ✅ 自动生成 config.php
- ✅ 自动设置管理员密码
- ✅ 自动重命名后台目录

### 6. 安装完成

按提示进入后台，修改个人资料，点击「一键生成」即可！

---

## 手动安装

如果无法使用安装向导：

### 1. 创建数据库

```sql
CREATE DATABASE homepage DEFAULT CHARSET utf8mb4;
```

### 2. 导入数据

```bash
mysql -u root -p homepage < database/gerenzhuye.sql
```

### 3. 修改配置

```bash
cp config/config.sample.php config/config.php
```

编辑 `config/config.php`：

```php
define('SITE_URL', 'https://你的域名');
define('DB_NAME', 'homepage');
define('DB_USER', 'root');
define('DB_PASS', '你的密码');
```

### 4. 设置权限

```bash
chown -R www:www .
chmod -R 755 .
chmod -R 777 posts/ assets/music/ config/
```

### 5. 访问后台

```
https://你的域名/admin/login.php
默认账号: admin
```

---

## 安装后

1. 进入后台修改密码（「管理员设置」）
2. 修改个人资料（「资料配置」）
3. 点击「一键生成」生成首页
4. 可选修改后台目录名

## 环境要求

- PHP >= 7.4
- MySQL >= 5.7
- Nginx / Apache
- 需要 pdo_mysql 扩展

## 注意事项

- 安装完成后建议删除 `install.php`（系统会自动创建 install.lock 防止重复安装）
- 音乐文件放在 `assets/music/` 目录
- 生产环境确保 `config/config.php` 不可公开访问

---

有问题？查看 [README.md](README.md) 或提交 Issue。