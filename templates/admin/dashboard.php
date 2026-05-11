<?php if(!empty($msg)):?><div class="msg ok">✓ <?=$msg?></div><?php endif;?>
<div class="stats">
    <div class="stat"><strong><?=$article_count ?? 0?></strong><span>动态总数</span></div>
    <div class="stat"><strong><?=$article_count ?? 0?></strong><span>文章页数</span></div>
    <div class="stat"><strong><?=$generated ? '已' : '未'?></strong><span>静态生成</span></div>
    <div class="stat"><strong><?=$site_name ?? '未设置'?></strong><span>站名</span></div>
</div>
<div class="card">
    <h3>系统信息</h3>
    <table style="width:auto">
        <tr><td>版本</td><td><strong><?=APP_VERSION?></strong></td></tr>
        <tr><td>发布日期</td><td><?=APP_RELEASE_DATE?></td></tr>
        <tr><td>开发者</td><td><?=APP_AUTHOR?></td></tr>
        <tr><td>主题数量</td><td>3 (default_bento / tech_minimal / apple_dark)</td></tr>
        <tr><td>当前主题</td><td><?=$active_theme ?? 'default_bento'?></td></tr>
    </table>
</div>
<div class="card">
    <h3>最近动态</h3>
    <?php if(!empty($recent)):?>
    <table><thead><tr><th>标题</th><th>类型</th><th>时间</th><th>操作</th></tr></thead>
    <tbody>
    <?php foreach($recent as $a): ?>
    <tr><td><?=h($a['title'])?></td><td><?=$a['type']?></td><td><?=$a['add_time']?></td>
    <td class="actions"><a href="articles.php?edit=<?=$a['id']?>">编辑</a> <a href="articles.php?del=<?=$a['id']?>" onclick="return confirm('删除?')">删除</a></td></tr>
    <?php endforeach;?>
    </tbody></table>
    <?php else:?><p style="color:var(--muted)">暂无动态</p><?php endif;?>
</div>
<div class="card">
    <h3>快捷操作</h3>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
        <a class="btn" href="articles.php?new=1">➕ 发布动态</a>
        <a class="btn" href="config.php">⚙️ 修改配置</a>
        <a class="btn primary" href="generate.php">🚀 生成静态页</a>
        <a class="btn" href="<?=SITE_URL?>" target="_blank">🌐 查看主页</a>
    </div>
</div>
