<?php if(!empty($msg)):?><div class="msg <?=($msgType==='ok'?'ok':'err')?>"><?=$msg?></div><?php endif;?>

<div class="settings-container">
    <!-- 修改密码 -->
    <div class="card">
        <h3>🔑 修改密码</h3>
        <form method="post">
            <input type="hidden" name="action" value="change_password">
            <div class="field">
                <label>当前用户名</label>
                <input type="text" value="<?=h($currentUsername)?>" disabled>
            </div>
            <div class="field">
                <label>原密码</label>
                <input type="password" name="old_password" required placeholder="请输入当前密码">
            </div>
            <div class="field">
                <label>新密码 <small style="color:var(--muted)">至少6位</small></label>
                <input type="password" name="new_password" id="newPwd" required placeholder="请输入新密码" oninput="checkPwdStrength(this.value)">
            </div>
            <div class="field">
                <label>确认新密码</label>
                <input type="password" name="confirm_password" id="confirmPwd" required placeholder="请再次输入新密码">
            </div>
            <div id="pwdStrength" style="font-size:12px;margin:8px 0"></div>
            <button class="btn primary" type="submit" onclick="return confirmPwdMatch()">💾 修改密码</button>
        </form>
    </div>

    <!-- 修改后台目录 -->
    <div class="card" style="margin-top:24px">
        <h3>📁 修改后台目录</h3>
        <p style="color:var(--muted);font-size:13px;margin-bottom:16px">
            修改后将自动跳转到新地址，请牢记新后台路径
        </p>
        <form method="post">
            <input type="hidden" name="action" value="change_admin_dir">
            <div class="field">
                <label>当前后台地址</label>
                <input type="text" value="https://cf.5276.net/<?=$currentDir?>/" disabled>
            </div>
            <div class="field">
                <label>新后台目录名 <small style="color:var(--muted)">英文、数字、下划线</small></label>
                <input type="text" name="new_admin_dir" id="newDirInput" value="<?=$currentDir?>" placeholder="如：yunlian" oninput="previewAdminUrl(this.value)" required pattern="[a-zA-Z0-9_]+">
            </div>
            <div id="dirPreview" style="font-size:13px;color:var(--muted);margin:8px 0">
                新地址：https://cf.5276.net/<?=$currentDir?>/
            </div>
            <button class="btn primary" type="submit" onclick="return confirmDirChange()">🔄 修改并跳转</button>
        </form>
    </div>

    <!-- 安全提示 -->
    <div class="card" style="margin-top:24px">
        <h3>⚠️ 安全提示</h3>
        <ul style="color:var(--muted);font-size:13px;line-height:2;padding-left:20px">
            <li>修改后台目录名后，旧地址将失效（404）</li>
            <li>建议使用不易猜测的目录名（如 <code>mgmt_x7k2</code>）</li>
            <li>密码建议包含大小写字母+数字+特殊字符</li>
            <li>修改目录会清除当前登录状态，需重新登录</li>
        </ul>
    </div>
</div>

<script>
function checkPwdStrength(pwd) {
    var el = document.getElementById('pwdStrength');
    if (!pwd) { el.innerHTML = ''; return; }
    var s = 0;
    if (pwd.length >= 6) s++;
    if (pwd.length >= 10) s++;
    if (/[A-Z]/.test(pwd) && /[a-z]/.test(pwd)) s++;
    if (/\d/.test(pwd)) s++;
    if (/[^a-zA-Z0-9]/.test(pwd)) s++;
    var labels = ['', '弱', '较弱', '中等', '强', '很强'];
    var colors = ['', '#ff3b30', '#ff9500', '#ffcc00', '#34c759', '#30d158'];
    el.innerHTML = '密码强度：<span style="color:'+colors[s]+'">'+labels[s]+'</span>';
}

function confirmPwdMatch() {
    var a = document.getElementById('newPwd').value;
    var b = document.getElementById('confirmPwd').value;
    if (a !== b) { alert('两次输入的新密码不一致'); return false; }
    if (a.length < 6) { alert('新密码至少6位'); return false; }
    return confirm('确认修改密码？');
}

function previewAdminUrl(val) {
    var clean = val.replace(/[^a-zA-Z0-9_]/g, '');
    document.getElementById('newDirInput').value = clean;
    document.getElementById('dirPreview').innerHTML = '新地址：https://cf.5276.net/' + (clean || '...') + '/';
}

function confirmDirChange() {
    var dir = document.getElementById('newDirInput').value;
    if (!dir) { alert('请输入目录名'); return false; }
    return confirm('确认将后台目录修改为 /' + dir + '/ ？\n\n修改后旧地址将失效，需使用新地址登录。');
}
</script>