<!DOCTYPE html>
<html lang="zh" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="<?=SITE_URL?>/">
<?php
// === 全能适配协议 - $CTX 数据总线 ===
// 模板通过 $CTX['basic']['name'] 方式调用，强制 if(!empty()) 包裹
$B = $CTX['basic'] ?? [];      // 基础信息
$S = $CTX['social'] ?? [];     // 社交链接
$L = $CTX['list'] ?? [];       // 列表数据
$H = $CTX['hobby'] ?? [];      // 爱好数据
$SYS = $CTX['system'] ?? [];   // 系统配置
$SEO = $CTX['seo'] ?? [];      // SEO配置

// 兼容旧变量名
$config = [
    'name' => $B['name'] ?? '',
    'job_title' => $B['job_title'] ?? '',
    'bio_summary' => $B['bio_summary'] ?? '',
    'avatar_url' => $B['avatar_url'] ?? '',
    'now_text' => $B['now_text'] ?? '',
    'icp_info' => $CTX['icp'] ?? '',
    'footer_copyright' => $CTX['copyright'] ?? '',
];
$seo = $SEO;
$siteTitle = $SEO['title'] ?? ($B['name'] . ' - 个人主页');
$hero_stats = $CTX['hero_stats'] ?? [];
$hero_tags = $B['status_tags'] ?? ['📍 上海', '✈ 旅行中', '⌨ 开源贡献'];
$skills = $L['skills'] ?? [];
$social = $S;
$travel = $L['travel'] ?? [];
$projects = $L['projects'] ?? [];
$investment = $H['investment'] ?? ['returns'=>'','total'=>'','allocations'=>[]];
$media = $H['media'] ?? [];
$postsUrl = $posts_url ?? ('/' . ($SYS['posts_slug'] ?? 'posts'));
?>
<title><?=h($siteTitle)?></title>
<meta name="keywords" content="<?=h($seo['keywords'] ?? '')?>">
<meta name="description" content="<?=h($seo['description'] ?? $config['bio_summary'])?>">
<?php if(!empty($config['icp_info'])):?><meta name="icp" content="<?=h($config['icp_info'])?>"><?php endif;?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@300;400;500&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
[data-theme="light"]{
  --bg0:#f0ede8;--bg1:#e8e4de;--bg2:#dedad4;
  --glass:rgba(255,255,255,0.55);--glass-hover:rgba(255,255,255,0.72);
  --glass-border:rgba(255,255,255,0.75);--glass-border-hover:rgba(193,125,78,0.4);
  --text:#2a2520;--text2:#7a7068;--text3:#aaa49c;
  --accent:#c17d4e;--accent2:#7fa882;--accent3:#5b7fa8;
  --accent-dim:rgba(193,125,78,0.13);--accent2-dim:rgba(127,168,130,0.15);--accent3-dim:rgba(91,127,168,0.13);
  --green:#4a8050;--green-dim:rgba(74,128,80,0.12);
  --amber:#a06030;--amber-dim:rgba(193,125,78,0.12);
  --blue:#3a5a8a;--blue-dim:rgba(58,90,138,0.12);
  --hero-bg:linear-gradient(135deg,#d4c8bc 0%,#c2b8ac 40%,#b8cfc0 100%);
  --hero-glow:rgba(193,125,78,0.15);
  --avatar-bg:linear-gradient(145deg,#c17d4e,#e8a87c);
  --dot:#7fa882;--tag-bg:rgba(255,255,255,0.5);
  --stat-num:#2a2520;--stat-accent:#c17d4e;
  --shadow:0 4px 24px rgba(100,80,60,0.10);--shadow-hover:0 8px 36px rgba(100,80,60,0.18);
  --card-deco:rgba(193,125,78,0.06);--sep:rgba(0,0,0,0.06);
  --chip-hover-border:rgba(193,125,78,0.4);--chip-hover-color:#c17d4e;
  --clink-hover-border:rgba(193,125,78,0.4);--clink-hover-color:#c17d4e;--clink-hover-bg:rgba(193,125,78,0.08);
  --bar1:linear-gradient(90deg,#c17d4e,#e8a87c);--bar2:#7fa882;--bar3:#5b7fa8;--bar4:#aaa49c;
  --proj-hover-border:rgba(91,127,168,0.4);--proj-hover-bg:rgba(91,127,168,0.06);
  --hero-border:rgba(0,0,0,0.06);
  --mono-font:'Inter',sans-serif;--serif-font:'Noto Serif SC',serif;
  --tmap-bg:linear-gradient(135deg,#c8d8cc 0%,#c0ccd8 100%);
  --tmap-border:rgba(255,255,255,0.4);
  --path-color:rgba(90,120,100,0.35);--dot-color:#5b8870;--dot-glow:rgba(91,136,112,0.3);
}
[data-theme="dark"]{
  --bg0:#080c14;--bg1:#0d1220;--bg2:#111827;
  --glass:rgba(255,255,255,0.04);--glass-hover:rgba(255,255,255,0.07);
  --glass-border:rgba(255,255,255,0.08);--glass-border-hover:rgba(0,210,255,0.35);
  --text:#e8edf5;--text2:#7a8ba8;--text3:#3d4f68;
  --accent:#00d2ff;--accent2:#3b6aff;--accent3:#00e5a0;
  --accent-dim:rgba(0,210,255,0.12);--accent2-dim:rgba(59,106,255,0.12);--accent3-dim:rgba(0,229,160,0.10);
  --green:#00e5a0;--green-dim:rgba(0,229,160,0.12);
  --amber:#ffb340;--amber-dim:rgba(255,179,64,0.12);
  --blue:#7ba4ff;--blue-dim:rgba(59,106,255,0.15);
  --hero-bg:linear-gradient(180deg,rgba(0,210,255,0.05) 0%,transparent 100%);
  --hero-glow:rgba(0,210,255,0.12);
  --avatar-bg:linear-gradient(135deg,#3b6aff 0%,#00d2ff 100%);
  --dot:#00e5a0;--tag-bg:rgba(255,255,255,0.05);
  --stat-num:#e8edf5;--stat-accent:#00d2ff;
  --shadow:0 4px 24px rgba(0,0,0,0.3);--shadow-hover:0 8px 40px rgba(0,0,0,0.5);
  --card-deco:rgba(0,210,255,0.04);--sep:rgba(255,255,255,0.04);
  --chip-hover-border:rgba(0,210,255,0.4);--chip-hover-color:#00d2ff;
  --clink-hover-border:rgba(0,210,255,0.35);--clink-hover-color:#00d2ff;--clink-hover-bg:rgba(0,210,255,0.08);
  --bar1:linear-gradient(90deg,#3b6aff,#00d2ff);--bar2:#00e5a0;--bar3:#00d2ff;--bar4:#ffb340;
  --proj-hover-border:rgba(59,106,255,0.4);--proj-hover-bg:rgba(59,106,255,0.06);
  --hero-border:rgba(255,255,255,0.06);
  --mono-font:'JetBrains Mono',monospace;--serif-font:'Inter',sans-serif;
  --tmap-bg:linear-gradient(135deg,#0d2340 0%,#0a2e28 100%);
  --tmap-border:rgba(0,210,255,0.12);
  --path-color:rgba(0,210,255,0.25);--dot-color:#00d2ff;--dot-glow:rgba(0,210,255,0.35);
}
html,body{background:var(--bg0);font-family:'Inter',sans-serif;color:var(--text);min-height:100vh;transition:background .5s,color .5s}
#particle-canvas{position:fixed;inset:0;z-index:0;pointer-events:none;opacity:0;transition:opacity .8s}
[data-theme="dark"] #particle-canvas{opacity:1}
.page{position:relative;z-index:1}

/* TOGGLE */
.toggle-wrap{position:fixed;top:18px;right:18px;z-index:100}
.toggle-btn{display:flex;align-items:center;gap:8px;padding:8px 16px;border-radius:30px;border:1px solid var(--glass-border);background:var(--glass);backdrop-filter:blur(16px);cursor:pointer;color:var(--text);font-size:13px;font-weight:500;transition:all .25s;box-shadow:var(--shadow)}
.toggle-btn:hover{border-color:var(--glass-border-hover);transform:scale(1.04);box-shadow:var(--shadow-hover)}
.toggle-icon{font-size:14px;transition:all .4s}
.toggle-track{width:34px;height:18px;border-radius:9px;background:var(--bg2);border:1px solid var(--glass-border);position:relative;transition:background .3s;flex-shrink:0}
[data-theme="dark"] .toggle-track{background:var(--accent)}
.toggle-knob{position:absolute;top:2px;left:2px;width:12px;height:12px;border-radius:50%;background:var(--text2);transition:all .3s}
[data-theme="dark"] .toggle-knob{left:18px;background:#fff}

/* HERO */
.hero{padding:56px 32px 44px;background:var(--hero-bg);border-bottom:1px solid var(--hero-border);position:relative;overflow:hidden;transition:background .5s,border-color .5s}
.hero::after{content:'';position:absolute;top:-80px;right:-60px;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,var(--hero-glow) 0%,transparent 70%);pointer-events:none}
.hero-row{display:flex;align-items:center;gap:24px}
.avatar-wrap{position:relative;flex-shrink:0}
.avatar{width:86px;height:86px;border-radius:50%;background:var(--avatar-bg);display:flex;align-items:center;justify-content:center;font-family:var(--serif-font);font-size:30px;font-weight:500;color:#fff;box-shadow:0 0 0 1px var(--glass-border),0 4px 20px rgba(0,0,0,0.15);transition:all .5s;position:relative;overflow:hidden}
[data-theme="dark"] .avatar::before{content:'';position:absolute;inset:-3px;border-radius:50%;background:conic-gradient(#00d2ff,#3b6aff,#00d2ff);z-index:-1;animation:spin 6s linear infinite;opacity:.5}
.avatar img{width:100%;height:100%;object-fit:cover}
@keyframes spin{to{transform:rotate(360deg)}}
.status-dot{position:absolute;bottom:3px;right:3px;width:15px;height:15px;border-radius:50%;background:var(--dot);border:2.5px solid var(--bg0);animation:pulse 2.2s infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(127,168,130,.4)}50%{box-shadow:0 0 0 6px rgba(127,168,130,0)}}
@keyframes pulse-d{0%,100%{box-shadow:0 0 0 0 rgba(0,229,160,0.4)}50%{box-shadow:0 0 0 6px rgba(0,229,160,0)}}
[data-theme="dark"] .status-dot{animation:pulse-d 2.2s infinite}
.hero-name{font-size:27px;font-weight:600;letter-spacing:.03em;line-height:1.2;transition:color .5s}
[data-theme="light"] .hero-name{font-family:'Noto Serif SC',serif;font-weight:500}
.hero-sub{font-size:13px;color:var(--text2);margin-top:5px;letter-spacing:.06em;transition:color .5s}
[data-theme="dark"] .hero-sub{font-family:'JetBrains Mono',monospace}
.hero-tags{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
.htag{font-size:11px;padding:4px 12px;border-radius:20px;border:1px solid var(--glass-border);background:var(--tag-bg);color:var(--text2);letter-spacing:.05em;backdrop-filter:blur(8px)}
.htag.live{border-color:var(--accent);color:var(--accent);background:var(--accent-dim)}
.hero-stats{display:flex;gap:28px;margin-top:24px}
.stat .num{font-size:22px;font-weight:600;color:var(--stat-num);transition:color .5s}
.stat .num em{font-style:normal;font-size:13px;color:var(--stat-accent);transition:color .5s}
.stat .lbl{font-size:11px;color:var(--text3);margin-top:3px;letter-spacing:.06em}

/* BENTO */
.bento{display:grid;grid-template-columns:repeat(12,1fr);gap:13px;padding:16px 16px 36px}
.card{background:var(--glass);border:1px solid var(--glass-border);border-radius:18px;backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);padding:20px;box-shadow:var(--shadow);transition:border-color .25s,background .25s,transform .25s,box-shadow .25s;overflow:hidden;position:relative;animation:fadeUp .5s ease both}
.card::before{content:'';position:absolute;inset:0;border-radius:18px;background:radial-gradient(ellipse at 10% 0%,var(--card-deco) 0%,transparent 60%);pointer-events:none}
.card:hover{border-color:var(--glass-border-hover);background:var(--glass-hover);transform:translateY(-3px);box-shadow:var(--shadow-hover)}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.card:nth-child(1){animation-delay:.04s}.card:nth-child(2){animation-delay:.08s}.card:nth-child(3){animation-delay:.12s}.card:nth-child(4){animation-delay:.16s}.card:nth-child(5){animation-delay:.20s}.card:nth-child(6){animation-delay:.24s}.card:nth-child(7){animation-delay:.28s}.card:nth-child(8){animation-delay:.32s}.card:nth-child(9){animation-delay:.36s}.card:nth-child(10){animation-delay:.40s}
.span-4{grid-column:span 4}.span-5{grid-column:span 5}.span-6{grid-column:span 6}.span-7{grid-column:span 7}.span-8{grid-column:span 8}.span-12{grid-column:span 12}

/* LABEL */
.clabel{font-size:10px;font-weight:500;letter-spacing:.13em;color:var(--text3);text-transform:uppercase;margin-bottom:14px;display:flex;align-items:center;gap:8px}
[data-theme="dark"] .clabel::before{content:'';width:14px;height:1px;background:var(--accent);opacity:.6}
[data-theme="light"] .clabel::before{content:'';width:14px;height:1px;background:var(--accent);opacity:.5}

/* ABOUT */
.bio{font-size:13px;line-height:1.9;color:var(--text2);margin-bottom:16px}
.chips{display:flex;flex-wrap:wrap;gap:6px}
.chip{font-size:11px;padding:4px 12px;border-radius:20px;border:1px solid var(--glass-border);background:rgba(255,255,255,.03);color:var(--text2);cursor:default;transition:border-color .2s,color .2s}
[data-theme="light"] .chip{background:rgba(255,255,255,.4)}
.chip:hover{border-color:var(--chip-hover-border);color:var(--chip-hover-color)}

/* NOW */
.now-text{font-size:15px;line-height:1.8;color:var(--text);border-left:2px solid var(--accent);padding-left:14px;margin-bottom:14px;font-weight:300;font-style:italic}
[data-theme="light"] .now-text{font-family:'Noto Serif SC',serif}
.now-sub{font-size:12px;color:var(--text3);line-height:1.8}

/* ACTIVITY */
.act-list{list-style:none}
.act-item{display:flex;gap:12px;align-items:flex-start;padding:9px 0;border-bottom:1px solid var(--sep)}
.act-item:last-child{border:none}
.act-item a{color:inherit;text-decoration:none}
.act-item a:hover .act-t{text-decoration:underline}
.act-icon{width:32px;height:32px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:14px}
.act-t{font-size:13px;color:var(--text);line-height:1.5}
.act-s{font-size:11px;color:var(--text3);margin-top:3px}
[data-theme="dark"] .act-s{font-family:'JetBrains Mono',monospace}

/* TRAVEL */
.tmap{height:104px;border-radius:11px;margin-bottom:14px;background:var(--tmap-bg);border:1px solid var(--tmap-border);position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center}
.tmap svg{position:absolute;inset:0;width:100%;height:100%}
.trip-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--sep)}
.trip-row:last-child{border:none}
.trip-place{font-size:13px;color:var(--text)}
.trip-date{font-size:11px;color:var(--text3);margin-top:2px}
.tbadge{font-size:10px;padding:3px 10px;border-radius:10px;letter-spacing:.04em}
.tbadge.done{background:var(--green-dim);color:var(--green)}
.tbadge.plan{background:var(--amber-dim);color:var(--amber)}

/* PROJECTS */
.proj-list{display:flex;flex-direction:column;gap:8px}
.proj{padding:12px 14px;border-radius:11px;background:rgba(255,255,255,.04);border:1px solid var(--glass-border);cursor:pointer;transition:border-color .2s,background .2s}
[data-theme="light"] .proj{background:rgba(255,255,255,.4)}
.proj:hover{border-color:var(--proj-hover-border);background:var(--proj-hover-bg)}
.proj-name{font-size:13px;font-weight:500;color:var(--text)}
.proj-desc{font-size:12px;color:var(--text2);margin-top:3px}
.proj-pills{display:flex;gap:6px;margin-top:8px}
.ppill{font-size:10px;padding:2px 8px;border-radius:6px}
.ppill-g{background:var(--green-dim);color:var(--green)}
.ppill-b{background:var(--blue-dim);color:var(--blue)}
.ppill-a{background:var(--amber-dim);color:var(--amber)}

/* INVESTMENT */
.inv-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.inv-card{background:rgba(255,255,255,.04);border:1px solid var(--glass-border);border-radius:11px;padding:10px 14px}
[data-theme="light"] .inv-card{background:rgba(255,255,255,.45)}
.inv-val{font-size:20px;font-weight:600}
.inv-lbl{font-size:11px;color:var(--text3);margin-top:2px}
.bar-rows{display:flex;flex-direction:column;gap:9px}
.bar-row{display:flex;align-items:center;gap:10px;font-size:12px}
.bar-lbl{width:56px;color:var(--text3);font-size:11px}
[data-theme="dark"] .bar-lbl{font-family:'JetBrains Mono',monospace}
.bar-track{flex:1;height:5px;border-radius:3px;background:rgba(128,128,128,.1);overflow:hidden}
.bar-fill{height:100%;border-radius:3px;width:0;transition:width 1.2s cubic-bezier(.22,.8,.32,1)}
.bar-pct{width:32px;text-align:right;color:var(--text2);font-size:11px}

/* MEDIA */
.media-item{display:flex;gap:12px;align-items:center;padding:9px 0;border-bottom:1px solid var(--sep)}
.media-item:last-child{border:none}
.mcov{width:40px;height:40px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:18px}
.mttl{font-size:13px;color:var(--text)}
.msub{font-size:11px;color:var(--text3);margin-top:2px}
.mprog{height:3px;border-radius:2px;background:rgba(128,128,128,.12);margin-top:6px;overflow:hidden}
.mprog-fill{height:100%;border-radius:2px;background:var(--bar1)}

/* CONTACT */
.clinks{display:flex;flex-direction:column;gap:7px}
.clink{display:flex;align-items:center;gap:12px;font-size:13px;color:var(--text2);padding:9px 14px;border-radius:11px;border:1px solid var(--glass-border);background:rgba(255,255,255,.04);transition:all .2s;text-decoration:none}
[data-theme="light"] .clink{background:rgba(255,255,255,.42)}
.clink:hover{border-color:var(--clink-hover-border);color:var(--clink-hover-color);background:var(--clink-hover-bg)}
.cico{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0}

.footer{padding:32px;text-align:center;color:var(--text3);font-size:12px}
@media(max-width:680px){.span-4,.span-5,.span-6,.span-7,.span-8{grid-column:span 12}.bento{padding:10px;gap:10px}.hero{padding:40px 20px 32px}.hero-stats{gap:18px;flex-wrap:wrap}}
</style>
<?php if(!empty($SYS['custom_header'])):?><?=$SYS['custom_header']?><?php endif;?>
</head>
<body>
<canvas id="particle-canvas"></canvas>
<div class="toggle-wrap">
  <button class="toggle-btn" onclick="toggleTheme()">
    <span id="toggle-icon">☀️</span>
    <div class="toggle-track"><div class="toggle-knob"></div></div>
    <span id="toggle-label" style="font-size:12px;color:var(--text2)">日间</span>
  </button>
</div>

<div class="page">
<!-- HERO -->
<div class="hero">
  <div class="hero-row">
    <div class="avatar-wrap">
      <div class="avatar">
<?php if(!empty($config['avatar_url'])):?>
        <img src="<?=h($config['avatar_url'])?>" alt="<?=h($config['name'])?>">
<?php else:?>
        <?=mb_substr($config['name'],0,1,'UTF-8')?>
<?php endif;?>
      </div>
      <div class="status-dot"></div>
    </div>
    <div>
      <div class="hero-name"><?=h($config['name'])?></div>
      <div class="hero-sub" id="hero-sub"><?=h($config['job_title'])?></div>
      <div class="hero-tags">
        <span class="htag live" id="htag-live">🟢 在线</span>
        <?php foreach($hero_tags as $tag): if($tag):?><span class="htag"><?=h($tag)?></span><?php endif; endforeach;?>
      </div>
    </div>
  </div>
  <?php if(!empty($hero_stats)):?>
  <div class="hero-stats"><?=renderHeroStats($hero_stats)?></div>
  <?php endif;?>
</div>

<!-- BENTO CARDS -->
<div class="bento">

  <!-- 1. 关于我 -->
  <div class="card span-7">
    <div class="clabel">关于我</div>
    <p class="bio"><?=nl2br(h($config['bio_summary']))?></p>
    <?php if(!empty($skills)):?>
    <div class="chips">
      <?php foreach($skills as $name=>$pct):?><span class="chip"><?=h($name)?></span><?php endforeach;?>
    </div>
    <?php endif;?>
  </div>

  <!-- 2. 此刻·Now -->
  <div class="card span-5">
    <div class="clabel">此刻 · Now</div>
    <?php if(!empty($config['now_text'])):?>
    <div class="now-text"><?=nl2br(h($config['now_text']))?></div>
    <?php else:?>
    <div class="now-text">正在忙碌中…</div>
    <?php endif;?>
  </div>

  <!-- 3. 日常动态 -->
  <div class="card span-5">
    <div class="clabel">日常动态</div>
    <ul class="act-list">
    <?php foreach($articles as $article):
      $style = getArticleStyle($article['type']);
    ?>
      <li class="act-item">
        <div class="act-icon" style="background:<?=$style['bg']?>"><?=$style['icon']?></div>
        <div>
          <a href="<?=h($postsUrl.'/'.$article['id'].'.html')?>">
            <div class="act-t"><?=h($article['summary'] ?: $article['title'])?></div>
            <div class="act-s"><?=$article['add_time']?></div>
          </a>
        </div>
      </li>
    <?php endforeach;?>
    <?php if(empty($articles)):?>
      <li class="act-item"><div class="act-icon" style="background:var(--sep)">📝</div><div><div class="act-t">暂无动态</div></div></li>
    <?php endif;?>
    </ul>
  </div>

  <!-- 4. 旅行足迹 -->
  <div class="card span-7">
    <div class="clabel">旅行足迹</div>
    <div class="tmap">
      <svg viewBox="0 0 300 104" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <radialGradient id="gd" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#00d2ff" stop-opacity="0.35"/>
            <stop offset="100%" stop-color="#00d2ff" stop-opacity="0"/>
          </radialGradient>
          <radialGradient id="gl" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#5b8870" stop-opacity="0.4"/>
            <stop offset="100%" stop-color="#5b8870" stop-opacity="0"/>
          </radialGradient>
        </defs>
        <path id="map-path" d="M20,80 Q60,20 110,48 Q150,70 200,28 Q230,12 270,38" fill="none" stroke-width="1.5" stroke-dasharray="4,3"/>
        <circle id="dot1" cx="110" cy="48" r="4"/>
        <circle id="dot1g" cx="110" cy="48" r="9"/>
        <circle id="dot2" cx="200" cy="28" r="4"/>
        <circle id="dot2g" cx="200" cy="28" r="9"/>
        <circle id="dot3" cx="20" cy="80" r="3" opacity="0.5"/>
        <text id="lbl1" x="114" y="44" font-size="8" font-family="Inter">京都</text>
        <text id="lbl2" x="204" y="24" font-size="8" font-family="Inter">冰岛</text>
      </svg>
    </div>
    <?php if(!empty($travel)):?>
    <?php foreach($travel as $t):?>
    <div class="trip-row">
      <div><div class="trip-place"><?=h($t['place'])?></div><div class="trip-date"><?=h($t['date'])?></div></div>
      <span class="tbadge <?=($t['status']??'done')?>"><?=($t['status']??'done')==='done'?'已完成':'计划中'?></span>
    </div>
    <?php endforeach;?>
    <?php endif;?>
  </div>

  <!-- 5. 项目展示 -->
  <div class="card span-6">
    <div class="clabel">项目展示</div>
    <?=renderProjects($projects)?>
  </div>

  <!-- 6. 投资记录 -->
  <div class="card span-6">
    <div class="clabel">投资记录</div>
    <?=renderInvestment($investment)?>
  </div>

  <!-- 7. 书影音 -->
  <div class="card span-5">
    <div class="clabel">书影音</div>
    <?=renderMedia($media)?>
  </div>

  <!-- 8. 联系方式 -->
  <div class="card span-7">
    <div class="clabel">联系方式</div>
    <div class="clinks">
    <?php foreach($social as $key=>$val):
      if(empty($val)) continue;
      $ic = getSocialStyle($key);
    ?>
      <a class="clink" href="<?=($key==='email'?'mailto:':'') . h($val)?>" target="_blank">
        <div class="cico" style="background:<?=$ic['bg']?>;color:<?=$ic['color']?>"><?=$ic['icon']?></div>
        <span><?=h($val)?></span>
      </a>
    <?php endforeach;?>
    </div>
  </div>

</div>
</div>

<div class="footer">
  <?=$config['footer_copyright'] ?: '© '.date('Y').' '.h($config['name'])?>
  <?php if(!empty($config['icp_info'])):?> · <a href="https://beian.miit.gov.cn" target="_blank" rel="nofollow" style="color:inherit"><?=h($config['icp_info'])?></a><?php endif;?>
</div>

<script>
const canvas=document.getElementById('particle-canvas'),ctx=canvas.getContext('2d');
let W,H,pts=[],raf;
function resize(){W=canvas.width=innerWidth;H=canvas.height=innerHeight}resize();addEventListener('resize',resize);
class P{constructor(){this.r()}r(){this.x=Math.random()*W;this.y=Math.random()*H;this.rad=Math.random()*1.1+.3;this.vx=(Math.random()-.5)*.22;this.vy=(Math.random()-.5)*.22;this.a=Math.random()*.45+.08;this.c=Math.random()>.65?'#00d2ff':'#3b6aff'}tick(){this.x+=this.vx;this.y+=this.vy;if(this.x<0||this.x>W||this.y<0||this.y>H)this.r()}draw(){ctx.beginPath();ctx.arc(this.x,this.y,this.rad,0,Math.PI*2);ctx.fillStyle=this.c;ctx.globalAlpha=this.a;ctx.fill()}}
for(let i=0;i<80;i++)pts.push(new P());
function drawLines(){for(let i=0;i<pts.length;i++)for(let j=i+1;j<pts.length;j++){const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.sqrt(dx*dx+dy*dy);if(d<110){ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);ctx.strokeStyle='#00d2ff';ctx.globalAlpha=(1-d/110)*.1;ctx.lineWidth=.5;ctx.stroke()}}}
function loop(){ctx.clearRect(0,0,W,H);drawLines();pts.forEach(p=>{p.tick();p.draw()});ctx.globalAlpha=1;raf=requestAnimationFrame(loop)}
loop();

let dark=false;const root=document.documentElement;
const heroSub=document.getElementById('hero-sub');
const heroSubLight="<?=addslashes($config['job_title'])?>";

function updateMapColors(){
  const pc=dark?'rgba(0,210,255,0.25)':'rgba(90,120,100,0.35)';
  const dc=dark?'#00d2ff':'#5b8870';
  const gi=dark?'url(#gd)':'url(#gl)';
  const lc=dark?'rgba(0,210,255,0.85)':'rgba(60,100,80,0.9)';
  const mp=document.getElementById('map-path'),d1=document.getElementById('dot1'),d1g=document.getElementById('dot1g'),d2=document.getElementById('dot2'),d2g=document.getElementById('dot2g'),d3=document.getElementById('dot3'),l1=document.getElementById('lbl1'),l2=document.getElementById('lbl2');
  if(mp)mp.setAttribute('stroke',pc);
  [d1,d2,d3].forEach(e=>{if(e)e.setAttribute('fill',dc)});
  [d1g,d2g].forEach(e=>{if(e)e.setAttribute('fill',gi)});
  [l1,l2].forEach(e=>{if(e)e.setAttribute('fill',lc)});
}

function toggleTheme(){
  dark=!dark;
  root.setAttribute('data-theme',dark?'dark':'light');
  document.getElementById('toggle-icon').textContent=dark?'🌙':'☀️';
  document.getElementById('toggle-label').textContent=dark?'夜间':'日间';
  const liveTag=document.getElementById('htag-live');
  if(liveTag) liveTag.textContent=dark?'🟢 Available':'🟢 在线';
  if(heroSub) heroSub.textContent=dark?'> Indie Maker · Explorer · Coder':heroSubLight;
  updateMapColors();
}
updateMapColors();
setTimeout(()=>{document.querySelectorAll('.bar-fill').forEach(el=>{el.style.width=el.getAttribute('data-w')||'0%'})},500);
</script>
<?php if(!empty($SYS['custom_footer'])):?><?=$SYS['custom_footer']?><?php endif;?>
</body>
</html>