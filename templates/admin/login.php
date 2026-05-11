<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$title ?? '后台登录'?></title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0a0a0a;font-family:Inter,system-ui,sans-serif;color:#e8edf5}
.login{width:360px;padding:40px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:24px;backdrop-filter:blur(20px)}
.login h1{font-size:22px;margin-bottom:8px;text-align:center}
.login p{color:#7a8ba8;font-size:13px;text-align:center;margin-bottom:28px}
.field{margin-bottom:16px}
.field label{display:block;font-size:12px;color:#7a8ba8;margin-bottom:6px;letter-spacing:0.05em}
.field input{width:100%;padding:12px 14px;border:1px solid rgba(255,255,255,0.1);border-radius:12px;background:rgba(255,255,255,0.04);color:#e8edf5;font-size:14px;outline:none;transition:border-color .2s}
.field input:focus{border-color:#00d2ff}
.btn{width:100%;padding:12px;border:0;border-radius:12px;background:linear-gradient(135deg,#00d2ff,#3b6aff);color:#fff;font-size:14px;font-weight:600;cursor:pointer;transition:opacity .2s}
.btn:hover{opacity:.9}
.error{color:#f87171;font-size:13px;text-align:center;margin-bottom:16px}
</style>
</head>
<body>
<div class="login">
    <h1>🛡️ 后台管理</h1>
    <p><?=$site_name ?? '个人主页系统'?></p>
    <?php if(!empty($error)):?><div class="error"><?=$error?></div><?php endif;?>
    <form method="post">
        <div class="field"><label>用户名</label><input type="text" name="username" required></div>
        <div class="field"><label>密码</label><input type="password" name="password" required></div>
        <button class="btn" type="submit">登 录</button>
    </form>
</div>
</body>
</html>