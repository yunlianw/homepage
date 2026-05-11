<?php
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$H = $CTX['hobby'] ?? [];
$config = [
    'name' => $B['name'] ?? '',
    'footer_copyright' => $CTX['copyright'] ?? '',
    'icp_info' => $CTX['icp'] ?? '',
];
$siteUrl = '/';
?>
<!DOCTYPE html>
<html lang="zh" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=h($article['title'] . ' - ' . $B['name'])?></title>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@300;400;500&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
[data-theme="light"]{
  --bg0:#f0ede8;--bg1:#e8e4de;
  --glass:rgba(255,255,255,0.55);--glass-hover:rgba(255,255,255,0.72);
  --glass-border:rgba(255,255,255,0.75);--glass-border-hover:rgba(193,125,78,0.4);
  --text:#2a2520;--text2:#7a7068;--text3:#aaa49c;
  --accent:#c17d4e;--accent-dim:rgba(193,125,78,0.13);
  --shadow:0 4px 24px rgba(100,80,60,0.10);--shadow-hover:0 8px 36px rgba(100,80,60,0.18);
  --sep:rgba(0,0,0,0.06);--serif-font:'Noto Serif SC',serif;
}
[data-theme="dark"]{
  --bg0:#080c14;--bg1:#0d1220;
  --glass:rgba(255,255,255,0.04);--glass-hover:rgba(255,255,255,0.07);
  --glass-border:rgba(255,255,255,0.08);--glass-border-hover:rgba(0,210,255,0.35);
  --text:#e8edf5;--text2:#7a8ba8;--text3:#3d4f68;
  --accent:#00d2ff;--accent-dim:rgba(0,210,255,0.12);
  --shadow:0 4px 24px rgba(0,0,0,0.3);--shadow-hover:0 8px 40px rgba(0,0,0,0.5);
  --sep:rgba(255,255,255,0.04);--serif-font:'Inter',sans-serif;
}
html,body{background:var(--bg0);font-family:'Inter',sans-serif;color:var(--text);min-height:100vh;transition:background .5s,color .5s}
#particle-canvas{position:fixed;inset:0;z-index:0;pointer-events:none;opacity:0;transition:opacity .8s}
[data-theme="dark"] #particle-canvas{opacity:1}
.page{position:relative;z-index:1;max-width:780px;margin:0 auto;padding:32px 20px}
.nav-bar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-radius:16px;background:var(--glass);border:1px solid var(--glass-border);backdrop-filter:blur(18px);margin-bottom:32px;box-shadow:var(--shadow)}
.nav-bar a{color:var(--text2);text-decoration:none;font-size:14px;font-weight:500;display:flex;align-items:center;gap:6px;transition:color .2s}
.nav-bar a:hover{color:var(--accent)}
.toggle-btn{display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:20px;border:1px solid var(--glass-border);background:var(--glass);cursor:pointer;color:var(--text);font-size:12px;transition:all .25s}
.toggle-btn:hover{border-color:var(--glass-border-hover)}
.article-header{margin-bottom:36px}
.article-header h1{font-size:clamp(24px,5vw,36px);font-weight:600;line-height:1.3;letter-spacing:-0.02em;margin-bottom:12px}
[data-theme="light"] .article-header h1{font-family:'Noto Serif SC',serif}
.article-meta{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
.meta-tag{font-size:12px;padding:4px 12px;border-radius:20px;border:1px solid var(--glass-border);background:var(--accent-dim);color:var(--accent)}
.meta-date{font-size:13px;color:var(--text3)}
[data-theme="dark"] .meta-date{font-family:'JetBrains Mono',monospace}
.article-summary{font-size:16px;line-height:1.8;color:var(--text2);padding:20px 24px;border-radius:16px;background:var(--glass);border:1px solid var(--glass-border);backdrop-filter:blur(18px);margin-bottom:32px;font-style:italic}
[data-theme="light"] .article-summary{font-family:'Noto Serif SC',serif}
.article-content{font-size:15px;line-height:2;color:var(--text)}
.article-content p{margin-bottom:16px}
.article-content h2,.article-content h3{margin:28px 0 14px;font-weight:600}
.article-content img{max-width:100%;border-radius:12px;margin:16px 0}
.article-content a{color:var(--accent);text-decoration:none}
.article-content a:hover{text-decoration:underline}
.article-content pre{background:rgba(0,0,0,0.15);padding:16px;border-radius:12px;overflow-x:auto;margin:16px 0;font-size:13px}
.article-content code{font-family:'JetBrains Mono',monospace;font-size:13px}
.article-content blockquote{border-left:3px solid var(--accent);padding-left:16px;color:var(--text2);margin:16px 0;font-style:italic}
.article-content ul,.article-content ol{padding-left:24px;margin-bottom:16px}
.article-content li{margin-bottom:6px}
.back-home{text-align:center;margin-top:48px;padding-top:32px;border-top:1px solid var(--sep)}
.back-home a{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:20px;background:var(--glass);border:1px solid var(--glass-border);color:var(--text2);text-decoration:none;font-size:14px;transition:all .25s}
.back-home a:hover{border-color:var(--glass-border-hover);color:var(--accent);transform:translateY(-2px)}
.footer{text-align:center;padding:32px 0;color:var(--text3);font-size:12px}
@media(max-width:680px){.page{padding:20px 16px}.nav-bar{padding:12px 16px}}
</style>
</head>
<body>
<canvas id="particle-canvas"></canvas>
<div class="page">
<nav class="nav-bar">
  <a href="<?=h($siteUrl)?>">← 返回首页</a>
  <button class="toggle-btn" onclick="toggleTheme()"><span id="toggle-icon">☀️</span> <span id="toggle-label">日间</span></button>
</nav>
<article>
  <div class="article-header">
    <h1><?=h($article['title'])?></h1>
    <div class="article-meta">
      <span class="meta-tag"><?=$article['type'] === 'dynamic' ? '日常动态' : h($article['type'])?></span>
      <span class="meta-date"><?=$article['add_time']?></span>
    </div>
  </div>
  <?php if(!empty($article['summary'])):?>
  <div class="article-summary"><?=h($article['summary'])?></div>
  <?php endif;?>
  <div class="article-content"><?=$article['content']?></div>
</article>
<div class="back-home"><a href="<?=h($siteUrl)?>">← 返回首页</a></div>
<div class="footer">
  <?=$config['footer_copyright'] ?: '© '.date('Y').' '.h($config['name'])?>
  <?php if(!empty($config['icp_info'])):?> · <?=h($config['icp_info'])?><?php endif;?>
</div>
</div>
<script>
const canvas=document.getElementById('particle-canvas'),ctx=canvas.getContext('2d');
let W,H,pts=[];
function resize(){W=canvas.width=innerWidth;H=canvas.height=innerHeight}resize();addEventListener('resize',resize);
class P{constructor(){this.r()}r(){this.x=Math.random()*W;this.y=Math.random()*H;this.rad=Math.random()*1.1+.3;this.vx=(Math.random()-.5)*.22;this.vy=(Math.random()-.5)*.22;this.a=Math.random()*.45+.08;this.c=Math.random()>.65?'#00d2ff':'#3b6aff'}tick(){this.x+=this.vx;this.y+=this.vy;if(this.x<0||this.x>W||this.y<0||this.y>H)this.r()}draw(){ctx.beginPath();ctx.arc(this.x,this.y,this.rad,0,Math.PI*2);ctx.fillStyle=this.c;ctx.globalAlpha=this.a;ctx.fill()}}
for(let i=0;i<60;i++)pts.push(new P());
function drawLines(){for(let i=0;i<pts.length;i++)for(let j=i+1;j<pts.length;j++){const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.sqrt(dx*dx+dy*dy);if(d<100){ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);ctx.strokeStyle='#00d2ff';ctx.globalAlpha=(1-d/100)*.08;ctx.lineWidth=.5;ctx.stroke()}}}
function loop(){ctx.clearRect(0,0,W,H);drawLines();pts.forEach(p=>{p.tick();p.draw()});ctx.globalAlpha=1;requestAnimationFrame(loop)}
loop();
let dark=false;const root=document.documentElement;
function toggleTheme(){dark=!dark;root.setAttribute('data-theme',dark?'dark':'light');document.getElementById('toggle-icon').textContent=dark?'🌙':'☀️';document.getElementById('toggle-label').textContent=dark?'夜间':'日间'}
</script>
</body>
</html>
