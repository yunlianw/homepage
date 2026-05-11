<?php if(!empty($msg)):?>
<div class="msg <?=$msgType==='ok'?'ok':'err'?>"><?=nl2br(h($msg))?></div>
<?php endif;?>

<div class="settings-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
    <!-- 修改密码 -->
    <div class="card" style="padding:24px">
        <h3>🔐 修改密码</h3>
        <form method="post" style="margin-top:16px">
            <input type="hidden" name="action" value="change_password">
            <div class="field">
                <label>用户名</label>
                <input name="new_username" value="<?=h($admin['username'])?>" placeholder="可修改用户名">
            </div>
            <div class="field">
                <label>原密码</label>
                <input type="password" name="old_password" placeholder="请输入当前密码" required>
            </div>
            <div class="field">
                <label>新密码 <small style="color:var(--muted)">至少6个字符</small></label>
                <input type="password" name="new_password" placeholder="请输入新密码" required minlength="6">
            </div>
            <div class="field">
                <label>确认新密码</label>
                <input type="password" name="cfm_password" placeholder="再次输入新密码" required>
            </div>
            <button class="btn primary" type="submit">💾 保存密码</button>
        </form>
    </div>

    <!-- 修改后台目录 -->
    <div class="card" style="padding:24px">
        <h3>📁 后台目录设置</h3>
        <div style="margin-top:16px;padding:12px;background:var(--bg2);border-radius:8px;margin-bottom:16px">
            <div style="font-size:13px;color:var(--muted)">当前后台地址</div>
            <div style="font-weight:600;margin-top:4px"><?=SITE_URL?>/<?=h($admin['admin_dir'])?>/</div>
        </div>
        <form method="post">
            <input type="hidden" name="action" value="change_dir">
            <div class="field">
                <label>新目录名 <small style="color:var(--muted)">字母/数字/横线/下划线</small></label>
                <input name="new_dir" value="<?=h($admin['admin_dir'])?>" placeholder="如: yunlian, manage" pattern="[a-zA-Z0-9_-]+" required>
            </div>
            <div style="padding:10px 14px;background:rgba(255,165,0,0.08);border-left:3px solid #ffa500;border-radius:0 8px 8px 0;margin-bottom:16px;font-size:13px;color:var(--muted)">
                ⚠️ 修改后旧地址将失效，请务必记住新地址！修改会自动备份记录。
            </div>
            <button class="btn primary" type="submit">📁 修改目录</button>
        </form>
    </div>
</div>

<style>
.settings-grid { max-width: 900px; }
@media(max-width:768px) { .settings-grid { grid-template-columns: 1fr !important; } }
.card { background: var(--bg1, #1a1f2e); border-radius: 12px; border: 1px solid var(--border, rgba(255,255,255,0.06)); }
.card h3 { margin: 0; font-size: 16px; }
</style>