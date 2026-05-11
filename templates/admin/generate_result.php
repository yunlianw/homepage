<div class="wrap" style="width:420px;padding:40px;background:var(--card);border:1px solid var(--border);border-radius:24px;text-align:center;margin:80px auto">
    <h1 style="font-size:28px;margin-bottom:8px">🚀 静态页生成</h1>
    <div style="color:var(--muted);font-size:14px;margin-bottom:24px"><?=$success?'生成完成':'生成失败'?></div>
    <div style="background:rgba(0,0,0,0.3);border-radius:var(--r);padding:16px;font-size:13px;line-height:1.8;text-align:left;margin-bottom:24px">
        <?php foreach($logs as $log): ?>
        <div style="color:<?=$log['type']==='ok'?'#4ade80':'#f87171'?>"><?=$log['msg']?></div>
        <?php endforeach;?>
    </div>
    <div style="display:flex;gap:12px;justify-content:center">
        <a class="btn" href="index.php">返回仪表盘</a>
        <a class="btn primary" href="<?=SITE_URL?>" target="_blank">查看主页</a>
    </div>
</div>