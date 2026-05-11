<?php
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$config = [
    'name' => $B['name'] ?? '',
    'footer_copyright' => $CTX['copyright'] ?? '',
    'icp_info' => $CTX['icp'] ?? '',
];
$siteUrl = '/';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?=h($article['title']??'文章详情')?> - <?=h($B['name']??'个人主页')?></title>
  <link rel="stylesheet" href="/themes/tech_minimal/style.css" />
</head>
<body data-theme="light">
  <canvas id="particleCanvas"></canvas>
  <div class="cursor-glow" id="cursorGlow"></div>

  <main class="page">
    <nav class="nav glass reveal">
      <a href="<?=$siteUrl?>" class="brand" aria-label="回到顶部">
        <span class="brand-dot"></span>
        <span><?=h($B['name']??'主页')?></span>
      </a>
      <div class="nav-right">
        <div class="nav-links">
          <a href="<?=$siteUrl?>">首页</a>
          <?php foreach($S as $k=>$v): if(!empty($v) && $k!=='wechat_qrcode'):?><a href="<?=h($v)?>" target="_blank"><?=h($k)?></a><?php endif;endforeach;?>
        </div>
        <div class="theme-switch" aria-label="配色切换">
          <button class="theme-btn active" data-theme-value="light" type="button">柔和</button>
          <button class="theme-btn" data-theme-value="dark" type="button">暗黑</button>
        </div>
      </div>
    </nav>

    <section class="glass bento-card span-2 reveal" style="margin-top:28px;padding:48px 42px;">
      <div class="card-head">
        <div class="icon"><?=h($article['icon']??'📝')?></div>
        <span class="tag"><?=h($article['type']??'动态')?></span>
      </div>
      <h1 class="scan-text" style="font-size:clamp(28px,4vw,46px);letter-spacing:-0.04em;margin:18px 0;" data-text="<?=h($article['title']??'')?>"><?=h($article['title']??'')?></h1>
      <div class="timeline-item">
        <div class="timeline-date"><?=h($article['created_at']??$article['add_time']??'')?></div>
        <div class="timeline-content"><span><?=h($B['name']??'')?> 发布</span></div>
      </div>
      <div style="margin-top:32px;line-height:2;font-size:16px;color:var(--text);"><?=$article['content']??''?></div>
      <div style="margin-top:40px;">
        <a class="btn primary" href="<?=$siteUrl?>">← 返回主页</a>
      </div>
    </section>

    <footer id="contact" class="footer" style="margin-top:44px;">
      <div><?=$config['footer_copyright'] ?: '© '.date('Y').' '.h($config['name'])?></div>
    </footer>
  </main>

  <script src="/themes/tech_minimal/main.js?v=<?=filemtime(ROOT_PATH.'/themes/tech_minimal/main.js')?>"></script>
</body>
</html>