<?php
/**
 * Tech Minimal 主题 - 全动态模板
 * 禁止硬编码，所有文字从后台数据读取
 */
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$H = $CTX['hobby'] ?? [];
$L = $CTX['list'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$STATS = $CTX['hero_stats'] ?? [];
$BLOCKS = $CTX['blocks'] ?? [];

// 导航项目（可从 ext 扩展）
$navItems = $SYS['ext']['nav_items'] ?? ['daily'=>'日常','travel'=>'旅行','projects'=>'项目','invest'=>'投资','contact'=>'联系'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?=h($B['name'] ?? '个人主页')?> - <?=h($B['job_title'] ?? '个人主页')?></title>
  <meta name="keywords" content="<?=h($CTX['seo']['keywords'] ?? '')?>" />
  <meta name="description" content="<?=h($CTX['seo']['description'] ?? $B['bio_summary'] ?? '')?>" />
  <link rel="stylesheet" href="/themes/tech_minimal/style.css" />
</head>
<body data-theme="light">
  <canvas id="particleCanvas"></canvas>
  <div class="cursor-glow" id="cursorGlow"></div>

  <main class="page">
    <nav class="nav glass reveal">
      <a href="#top" class="brand" aria-label="回到顶部">
        <span class="brand-dot"></span>
        <span><?=h($B['name'] ?? '个人主页')?></span>
      </a>
      <div class="nav-right">
        <div class="nav-links">
          <?php foreach($navItems as $id=>$label): ?>
          <a href="#<?=$id?>"><?=h($label)?></a>
          <?php endforeach;?>
        </div>
        <div class="theme-switch" aria-label="配色切换">
          <button class="theme-btn active" data-theme-value="light" type="button">柔和</button>
          <button class="theme-btn" data-theme-value="dark" type="button">暗黑</button>
        </div>
      </div>
    </nav>

    <section id="top" class="hero">
      <div class="glass hero-main reveal">
        <div>
          <div class="eyebrow">✨ <?=h($B['motto'] ?? $B['now_text'] ?? '记录 · 展示 · 成长')?></div>
          <h1 class="hero-title scan-text scan-line" data-text="<?=h($B['name'] ?? '你好')?>"></h1>
          <p class="hero-desc"><?=h($B['bio_summary'] ?? '')?></p>
          <div class="hero-actions">
            <a class="btn primary" href="#projects"><?=$SYS['ext']['btn_projects'] ?? '查看项目'?></a>
            <a class="btn" href="#daily"><?=$SYS['ext']['btn_recent'] ?? '最近动态'?></a>
          </div>
        </div>
      </div>

      <aside class="side-stack">
        <?php if(!empty($B['name'])): ?>
        <section class="glass profile-card reveal">
          <?php if(!empty($B['avatar_url'])): ?>
          <div class="avatar-wrap" style="background-image:url('<?=h($B['avatar_url'])?>')"></div>
          <?php else: ?>
          <div class="avatar-wrap"><?=mb_substr($B['name'],0,2)?></div>
          <?php endif;?>
          <div class="profile-list">
            <div class="profile-item"><span><?=$SYS['ext']['label_identity'] ?? '身份'?></span><span><?=h($B['job_title'] ?? '')?></span></div>
            <?php foreach($B['hero_tags'] ?? [] as $tag): ?>
            <div class="profile-item"><span><?=$SYS['ext']['label_interests'] ?? '关注'?></span><span><?=h($tag)?></span></div>
            <?php break; endforeach;?>
            <div class="profile-item"><span><?=$SYS['ext']['label_location'] ?? '位置'?></span><span><?=h($B['location'] ?? $STATS['location'] ?? '')?></span></div>
            <div class="profile-item"><span><?=$SYS['ext']['label_status'] ?? '状态'?></span><span><?=h(implode(' ', $B['status_tags'] ?? []))?></span></div>
          </div>
        </section>
        <?php endif;?>

        <section class="glass weather-card reveal">
          <div class="card-head">
            <div class="icon" id="weatherIcon">⏳</div>
            <span class="tag"><?=$SYS['ext']['weather_label'] ?? 'Weather'?></span>
          </div>
          <div class="weather-top">
            <div>
              <div class="weather-temp" id="weatherTemp">--°C</div>
              <div class="weather-desc" id="weatherDesc"><?=$SYS['ext']['weather_loading'] ?? '加载中...'?></div>
            </div>
          </div>
          <div class="weather-meta">
            <div class="weather-row"><span><?=$SYS['ext']['label_city'] ?? '城市'?></span><span id="weatherLocation"><?=$SYS['ext']['locating'] ?? '定位中...'?></span></div>
            <div class="weather-row"><span><?=$SYS['ext']['label_wind'] ?? '风速'?></span><span id="weatherWind">-- km/h</span></div>
            <div class="weather-row"><span><?=$SYS['ext']['label_status'] ?? '状态'?></span><span id="weatherStatus"><?=$SYS['ext']['browser_locate'] ?? '等待定位'?></span></div>
          </div>
        </section>
      </aside>
    </section>

    <section class="section-title reveal">
      <h2 class="scan-text" data-text="<?=$SYS['ext']['panel_title'] ?? '我的信息面板'?>"></h2>
      <p><?=h($SYS['ext']['panel_desc'] ?? '')?></p>
    </section>

    <section class="bento">
      <!-- 日常动态 -->
      <?php if(!empty($articles) && ($BLOCKS['daily'] ?? true)): ?>
      <article id="daily" class="glass bento-card span-2 reveal">
        <div>
          <div class="card-head"><div class="icon">☕</div><span class="tag">Daily Log</span></div>
          <h3><?=$SYS['ext']['daily_title'] ?? '日常活动'?></h3>
          <p><?=h($SYS['ext']['daily_desc'] ?? '')?></p>
          <div class="timeline">
            <?php foreach(array_slice($articles,0,2) as $art): ?>
            <div class="timeline-item">
              <div class="timeline-date"><?=date('m.d', strtotime($art['add_time'] ?? 'now'))?></div>
              <div class="timeline-content">
                <strong><a href="<?=$posts_url?>/<?=h($art['id'])?>.html"><?=h($art['title'])?></a></strong>
                <span><?=h(mb_substr(strip_tags($art['content'] ?? ''), 0, 60))?>...</span>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </article>
      <?php endif;?>

      <!-- 当前状态 -->
      <?php if(!empty($B['now_text']) && ($BLOCKS['now'] ?? true)): ?>
      <article class="glass bento-card reveal">
        <div><div class="card-head"><div class="icon">📌</div><span class="tag">Now</span></div><h3><?=$SYS['ext']['now_title'] ?? '当前状态'?></h3><p><?=h($B['now_text'])?></p></div>
        <div><div class="big-number"><?=h($STATS['projects'] ?? '0')?></div><div class="sub-number"><?=$SYS['ext']['projects_sub'] ?? '个项目进行中'?></div></div>
      </article>
      <?php endif;?>

      <!-- 投资记录 -->
      <?php if(!empty($H['investment']) && ($BLOCKS['invest'] ?? true)): ?>
      <article id="invest" class="glass bento-card reveal">
        <div><div class="card-head"><div class="icon">📈</div><span class="tag">Invest</span></div><h3><?=$SYS['ext']['invest_title'] ?? '投资记录'?></h3><p><?=h($SYS['ext']['invest_desc'] ?? '')?></p></div>
        <div><div class="big-number"><?=h($H['investment']['total'] ?? '0')?></div><div class="sub-number"><?=h($H['investment']['returns'] ?? '')?></div></div>
      </article>
      <?php endif;?>

      <!-- 旅行足迹 -->
      <?php if(!empty($L['travel']) && ($BLOCKS['travel'] ?? true)): ?>
      <article id="travel" class="glass bento-card span-2 span-row-2 reveal">
        <div class="travel-photo"></div>
        <div>
          <div class="card-head"><div class="icon">✈️</div><span class="tag">Travel</span></div>
          <h3><?=$SYS['ext']['travel_title'] ?? '旅行足迹'?></h3>
          <p><?=h($SYS['ext']['travel_desc'] ?? '')?></p>
          <div class="mini-grid">
            <div class="mini-stat"><strong><?=count($L['travel'])?></strong><span><?=$SYS['ext']['cities_visited'] ?? '城市'?></span></div>
            <div class="mini-stat"><strong><?=count($L['travel'])*3?></strong><span><?=$SYS['ext']['photos'] ?? '照片'?></span></div>
            <div class="mini-stat"><strong><?=count(array_filter($L['travel'], fn($t)=>($t['status']??'')=='plan'))?></strong><span><?=$SYS['ext']['planned'] ?? '计划中'?></span></div>
          </div>
          <div class="travel-list">
            <?php foreach(array_slice($L['travel'],0,4) as $t): ?>
            <div class="travel-item"><span><?=h($t['place'])?></span><small><?=h($t['date'])?></small></div>
            <?php endforeach;?>
          </div>
        </div>
      </article>
      <?php endif;?>

      <!-- 书影音 -->
      <?php if(!empty($H['media']) && ($BLOCKS['media'] ?? true)): ?>
      <article class="glass bento-card reveal">
        <div><div class="card-head"><div class="icon">📖</div><span class="tag">Media</span></div><h3><?=$SYS['ext']['media_title'] ?? '书影音'?></h3><p><?=h($SYS['ext']['media_desc'] ?? '')?></p></div>
        <div class="mini-grid" style="grid-template-columns: 1fr;"><div class="mini-stat"><strong><?=count($H['media'])?></strong><span><?=$SYS['ext']['media_count'] ?? '条记录'?></span></div></div>
      </article>
      <?php endif;?>

      <!-- 技能 -->
      <?php if(!empty($L['skills']) && ($BLOCKS['skills'] ?? true)): ?>
      <article class="glass bento-card reveal">
        <div><div class="card-head"><div class="icon">💡</div><span class="tag">Skills</span></div><h3><?=$SYS['ext']['skills_title'] ?? '技能'?></h3><p><?=h($SYS['ext']['skills_desc'] ?? '')?></p></div>
        <div><div class="big-number"><?=count($L['skills'])?></div><div class="sub-number"><?=$SYS['ext']['skills_count'] ?? '项技能'?></div></div>
      </article>
      <?php endif;?>

      <!-- 资产配置 -->
      <?php if(!empty($H['investment']['allocations']) && ($BLOCKS['invest'] ?? true)): ?>
      <article class="glass bento-card span-2 reveal">
        <div>
          <div class="card-head"><div class="icon">📊</div><span class="tag">Asset</span></div>
          <h3><?=$SYS['ext']['asset_title'] ?? '资产配置'?></h3>
          <p><?=h($SYS['ext']['asset_desc'] ?? '')?></p>
          <div class="bar-chart">
            <?php foreach($H['investment']['allocations'] as $alloc): ?>
            <div class="bar" data-label="<?=h($alloc['name'])?>" style="height:<?=h($alloc['pct'])?>%;background:<?=h($alloc['color'] ?? 'var(--accent)')?>"></div>
            <?php endforeach;?>
          </div>
        </div>
      </article>
      <?php endif;?>

      <!-- 座右铭 -->
      <?php if(!empty($B['motto'])): ?>
      <article class="glass bento-card span-2 reveal">
        <div class="quote">"<?=h($B['motto'])?>"<?php if(!empty($SYS['ext']['motto_sub'])):?><small><?=h($SYS['ext']['motto_sub'])?></small><?php endif;?></div>
      </article>
      <?php endif;?>
    </section>

    <!-- 项目展示书卷 -->
    <?php if(!empty($L['projects']) && ($BLOCKS['projects'] ?? true)): ?>
    <section id="projects" class="glass book-card reveal">
      <div class="section-title" style="margin:0;">
        <h2 class="scan-text" data-text="<?=$SYS['ext']['projects_title'] ?? '项目展示'?>"></h2>
        <p><?=h($SYS['ext']['projects_desc'] ?? '')?></p>
      </div>

      <div class="book-layout">
        <div class="book-stage">
          <div class="book" id="projectBook">
            <div class="book-base"></div>
            <div class="book-spine"></div>
            <?php $pageIdx = 1; foreach($L['projects'] as $proj): ?>
            <div class="paper" data-index="<?=$pageIdx?>">
              <div class="paper-face paper-front">
                <div class="page-meta">Project <?=sprintf('%02d', $pageIdx)?></div>
                <div class="page-title"><?=h($proj['name'] ?? '')?></div>
                <div class="page-text"><?=h($proj['desc'] ?? '')?></div>
                <?php if(!empty($proj['tags'])): ?>
                <ul class="page-list">
                  <?php foreach(array_slice($proj['tags'],0,3) as $tag): ?><li><?=h($tag['text'] ?? $tag)?></li><?php endforeach;?>
                </ul>
                <?php endif;?>
                <div class="page-num"><?=sprintf('%02d', $pageIdx)?></div>
              </div>
              <div class="paper-face paper-back">
                <div class="page-meta">Project <?=sprintf('%02d', $pageIdx)?></div>
                <div class="page-title"><?=$SYS['ext']['highlights_title'] ?? '核心亮点'?></div>
                <div class="page-text"><?=h($proj['highlights'] ?? $SYS['ext']['highlights_default'] ?? '')?></div>
                <div class="page-num"><?=sprintf('%02d', $pageIdx+1)?></div>
              </div>
            </div>
            <?php $pageIdx++; endforeach;?>
          </div>
        </div>

        <aside class="book-panel">
          <div class="book-tip"><h4><?=$SYS['ext']['book_tip_title'] ?? '操作提示'?></h4><p><?=h($SYS['ext']['book_tip_text'] ?? '点击翻页')?></p></div>
          <div class="book-controls">
            <div class="book-btns">
              <button class="btn" id="prevPageBtn" type="button"><?=$SYS['ext']['btn_prev'] ?? '上一页'?></button>
              <button class="btn primary" id="nextPageBtn" type="button"><?=$SYS['ext']['btn_next'] ?? '下一页'?></button>
              <button class="btn" id="resetBookBtn" type="button"><?=$SYS['ext']['btn_reset'] ?? '重置'?></button>
            </div>
            <div class="book-progress"><span id="bookProgress"></span></div>
          </div>
          <div class="book-status"><h4><?=$SYS['ext']['current_page'] ?? '当前页'?></h4><p id="bookStatusText">1 / <?=$pageIdx*2-2?></p></div>
        </aside>
      </div>
    </section>
    <?php endif;?>

    <footer id="contact" class="footer">
      <div><?=h($CTX['copyright'] ?? '© '.date('Y').' '.($B['name'] ?? '个人主页'))?></div>
      <?php if(!empty($S)): ?>
      <div class="socials">
        <?php foreach($S as $k=>$v): if($v && !empty($v)):?><a href="<?=h($v)?>" target="_blank"><?=h($k)?></a><?php endif;endforeach;?>
      </div>
      <?php endif;?>
      <?php if(!empty($CTX['icp'])): ?><div class="icp"><?=h($CTX['icp'])?></div><?php endif;?>
    </footer>
  </main>

<script>
// 读取服务端注入的天气数据
(function(){
  var w = document.getElementById('weather-data');
  if(!w) return;
  try{
    var d = JSON.parse(w.textContent);
    if(d.error) return;
    var el = function(i){return document.getElementById(i)};
    if(el('weatherTemp')) el('weatherTemp').textContent = d.temp;
    if(el('weatherDesc')) el('weatherDesc').textContent = d.condition;
    if(el('weatherLocation')) el('weatherLocation').textContent = d.location;
    if(el('weatherWind')) el('weatherWind').textContent = d.wind;
    if(el('weatherStatus')) el('weatherStatus').textContent = '已加载';
  }catch(e){}
})();
</script>
  <script src="/themes/tech_minimal/main.js?v=<?=filemtime(ROOT_PATH.'/themes/tech_minimal/main.js')?>"></script>
</body>
</html>