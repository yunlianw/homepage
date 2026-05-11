<?php
/**
 * Apple Dark 主题 - 基于2026.html 1:1还原
 */
// === $CTX 数据总线适配 ===
$B = $CTX['basic'] ?? [];
$H = $CTX['hobby'] ?? [];
$L = $CTX['list'] ?? [];
$S = $CTX['social'] ?? [];
$SYS = $CTX['system'] ?? [];
$SEO = $CTX['seo'] ?? [];
// 兼容旧变量名
$config = [
    'name' => $B['name'] ?? '',
    'job_title' => $B['job_title'] ?? '',
    'bio_summary' => $B['bio_summary'] ?? '',
];
$hero_stats = $CTX['hero_stats'] ?? [];
$social = $S;
$travel = $L['travel'] ?? [];
$projects = $L['projects'] ?? [];
$investment = $H['investment'] ?? [];
$media = $H['media'] ?? [];
$siteUrl = '/';
$articles = $articles ?? [];
$posts_url = $posts_url ?? '/posts';

$avatar_text = mb_substr($config['name'], 0, 2);
$name = $config['name'];
$role = $config['job_title'];
$bio = $config['bio_summary'];
?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=h($name)?> | <?=h($role)?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?=SITE_URL?>/themes/apple_dark/style.css">
</head>
<body>
<body>
    <!-- 主题切换按钮 -->
    <button class="theme-toggle" onclick="toggleTheme()" title="切换主题">
        <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
    </button>

    <div class="container">
        <!-- Hero -->
        <section class="hero">
            <div class="avatar-wrapper">
                <div class="avatar-glow"></div>
                <div class="avatar"><?=h($avatar_text)?></div>
            </div>
            <h1 class="name"><?=h($name)?></h1>
            <p class="role"><?=h($role)?></p>
            <p class="bio"><?=h($bio)?></p>
            <div class="location-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <?=h($location)?>
            </div>
            <div class="social-links">
                <a href="https://github.com" target="_blank" class="social-link" title="GitHub">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.652.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.475 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                <a href="mailto:alex@example.com" class="social-link" title="Email">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
                <a href="#" class="social-link" title="微信" onclick="showWechatModal(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.594.594 0 0 1 .225.62c-.048.227-.032.464.045.674a.696.696 0 0 0 .54.406c1.23.192 2.104.924 2.534 2.053.385-.227.832-.376 1.313-.441.348-.047.565-.176.565-.458v-.093a.572.572 0 0 1-.227-.507c.105-.166.16-.367.16-.58 0-.67-.577-1.214-1.288-1.214a.719.719 0 0 0-.662.475 2.28 2.28 0 0 1-.552.38.571.571 0 0 1-.454-.103.572.572 0 0 1-.222-.424c.057-.297.095-.608.095-.93 0-1.305-.912-2.359-2.036-2.359-.522 0-1.022.22-1.355.616a2.63 2.63 0 0 0-.564.917 2.334 2.334 0 0 0-.14-.508.585.585 0 0 0-.454-.458 1.872 1.872 0 0 0-.878-.192c-.69 0-1.252.381-1.692.784-.376.346-.653.846-.848 1.441z"/>
                    </svg>
                </a>
                <a href="https://blog.example.com" target="_blank" class="social-link" title="Blog">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </a>
            </div>
        </section>

        <!-- Grid -->
        <div class="grid">
            <!-- Stats -->
            <div class="card stats-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3v18h18"></path>
                        <path d="M18 17V9"></path>
                        <path d="M13 17V5"></path>
                        <path d="M8 17v-3"></path>
                    </svg>
                    <span class="card-title">数据统计</span>
                </div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">28</span>
                        <span class="stat-label">项目</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">12</span>
                        <span class="stat-label">国家</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">投资年</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">182</span>
                        <span class="stat-label">活跃天</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card links-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    <span class="card-title">快捷入口</span>
                </div>
                <div class="links-grid">
                    <a href="https://github.com" target="_blank" class="link-item">
                        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997z"/>
                        </svg>
                        <span class="link-text">GitHub</span>
                    </a>
                    <a href="mailto:alex@example.com" class="link-item">
                        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="link-text">Email</span>
                    </a>
                    <a href="#" class="link-item" onclick="showWechatModal(event)">
                        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55z"/>
                        </svg>
                        <span class="link-text">微信</span>
                    </a>
                    <a href="https://blog.example.com" target="_blank" class="link-item">
                        <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10z"></path>
                        </svg>
                        <span class="link-text">Blog</span>
                    </a>
                </div>
            </div>

            <!-- Hobbies -->
            <div class="card hobbies-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="card-title">爱好</span>
                </div>

                <div class="hobby-category">
                    <div class="hobby-category-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <path d="M6 12h4"></path>
                            <path d="M15 12h2"></path>
                        </svg>
                        游戏
                    </div>
                    <div class="hobby-tags">
                        <span class="hobby-tag">王者荣耀</span>
                        <span class="hobby-tag">坦克世界</span>
                        <span class="hobby-tag">FIFA</span>
                    </div>
                </div>

                <div class="hobby-category">
                    <div class="hobby-category-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18V5l12-2v13"></path>
                            <circle cx="6" cy="18" r="3"></circle>
                            <circle cx="18" cy="16" r="3"></circle>
                        </svg>
                        音乐
                    </div>
                    <div class="hobby-tags">
                        <span class="hobby-tag">赵雷</span>
                        <span class="hobby-tag">逃跑计划</span>
                        <span class="hobby-tag">痛仰</span>
                    </div>
                </div>

                <div class="hobby-category">
                    <div class="hobby-category-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        手办
                    </div>
                    <div class="hobby-tags">
                        <span class="hobby-tag">泡泡玛特</span>
                        <span class="hobby-tag">乌萨奇</span>
                        <span class="hobby-tag">Molly</span>
                    </div>
                </div>
            </div>

            <!-- Activities -->
            <?php if(!empty($articles)): ?>
            <div class="card activities-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="card-title"><?=$SYS['ext']['daily_title'] ?? '今日动态'?></span>
                </div>
                <div class="activity-list">
                    <?php foreach(array_slice($articles, 0, 5) as $art): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-time"><?=date('m-d', strtotime($art['add_time'] ?? 'now'))?></div>
                            <a href="<?=$posts_url?>/<?=h($art['id'])?>.html" class="activity-text" style="color:var(--text-primary);text-decoration:none"><?=h($art['title'])?></a>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif;?>

            <!-- Projects -->
            <?php if(!empty($projects)): ?>
            <div class="card projects-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    <span class="card-title"><?=$SYS['ext']['projects_title'] ?? '项目作品'?></span>
                </div>
                <div class="project-list">
                    <?php foreach($projects as $idx => $proj): 
                    $colors = ['linear-gradient(135deg, #2997ff, #5e5ce6)','linear-gradient(135deg, #30d158, #34c759)','linear-gradient(135deg, #ff375f, #ff6b6b)','linear-gradient(135deg, #ff9f0a, #ff6b6b)','linear-gradient(135deg, #bf5af2, #5e5ce6)'];
                    ?>
                    <div class="project-item" <?=(!empty($proj['url']) && $proj['url'] !== '#') ? 'onclick="window.open(\''.h($proj['url']).'\',\'_blank\')" style="cursor:pointer"' : ''?>>
                        <div class="project-cover" style="background: <?=h($colors[$idx % count($colors)])?>;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            </svg>
                        </div>
                        <div class="project-info">
                            <div class="project-name"><?=h($proj['name'] ?? '')?></div>
                            <div class="project-desc"><?=h($proj['desc'] ?? '')?></div>
                            <?php if(!empty($proj['tags'])): ?>
                            <div class="project-tags">
                                <?php foreach(array_slice($proj['tags'], 0, 3) as $tag): ?>
                                <span class="project-tag"><?=h($tag['text'] ?? $tag)?></span>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif;?>

            <!-- Travel -->
            <div class="card travel-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10z"></path>
                    </svg>
                    <span class="card-title">旅行记录</span>
                </div>
                <div class="travel-grid">
                    <div class="travel-item">
                        <div class="travel-thumb" style="background: linear-gradient(135deg, #ff4757, #ff6b81);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="travel-info">
                            <div class="travel-name">日本 · 东京</div>
                            <div class="travel-count">3 次访问</div>
                        </div>
                    </div>
                    <div class="travel-item">
                        <div class="travel-thumb" style="background: linear-gradient(135deg, #ffc048, #ffdd59);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="travel-info">
                            <div class="travel-name">泰国 · 清迈</div>
                            <div class="travel-count">2 次访问</div>
                        </div>
                    </div>
                    <div class="travel-item">
                        <div class="travel-thumb" style="background: linear-gradient(135deg, #70a1ff, #a4befe);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="travel-info">
                            <div class="travel-name">冰岛 · 雷克雅未克</div>
                            <div class="travel-count">1 次访问</div>
                        </div>
                    </div>
                    <div class="travel-item">
                        <div class="travel-thumb" style="background: linear-gradient(135deg, #2ed573, #7bed9f);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="travel-info">
                            <div class="travel-name">意大利 · 罗马</div>
                            <div class="travel-count">1 次访问</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment -->
            <div class="card investment-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    <span class="card-title">投资组合</span>
                </div>
                <div class="invest-overview">
                    <div class="invest-stat">
                        <div class="invest-label">总资产</div>
                        <div class="invest-value">¥1,250,000</div>
                    </div>
                    <div class="invest-stat">
                        <div class="invest-label">年化收益</div>
                        <div class="invest-value positive">+12.5%</div>
                    </div>
                </div>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: 30%;"></div>
                    <div class="chart-bar" style="height: 45%;"></div>
                    <div class="chart-bar" style="height: 35%;"></div>
                    <div class="chart-bar" style="height: 55%;"></div>
                    <div class="chart-bar" style="height: 50%;"></div>
                    <div class="chart-bar" style="height: 70%;"></div>
                    <div class="chart-bar" style="height: 65%;"></div>
                    <div class="chart-bar" style="height: 80%;"></div>
                    <div class="chart-bar" style="height: 75%;"></div>
                    <div class="chart-bar" style="height: 90%;"></div>
                    <div class="chart-bar" style="height: 85%;"></div>
                    <div class="chart-bar" style="height: 100%;"></div>
                </div>
                <div class="holdings-list">
                    <div class="holding-item">
                        <div class="holding-left">
                            <div class="holding-dot" style="background: #f7931a;"></div>
                            <span class="holding-name">BTC</span>
                        </div>
                        <span class="holding-percent">45%</span>
                        <span class="holding-change">+8.2%</span>
                    </div>
                    <div class="holding-item">
                        <div class="holding-left">
                            <div class="holding-dot" style="background: #627eea;"></div>
                            <span class="holding-name">ETH</span>
                        </div>
                        <span class="holding-percent">30%</span>
                        <span class="holding-change">+15.3%</span>
                    </div>
                    <div class="holding-item">
                        <div class="holding-left">
                            <div class="holding-dot" style="background: #00d1ff;"></div>
                            <span class="holding-name">纳指</span>
                        </div>
                        <span class="holding-percent">25%</span>
                        <span class="holding-change">+5.1%</span>
                    </div>
                </div>
            </div>

            <!-- Software -->
            <div class="card software-card">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <span class="card-title">常用软件</span>
                </div>
                <div class="software-list">
                    <a href="https://code.visualstudio.com" target="_blank" class="software-item">
                        <div class="software-icon" style="background: linear-gradient(135deg, #FF9500, #FF6B00);">V</div>
                        <div class="software-info">
                            <div class="software-name">VS Code</div>
                            <div class="software-desc">代码编辑器</div>
                        </div>
                    </a>
                    <a href="https://www.figma.com" target="_blank" class="software-item">
                        <div class="software-icon" style="background: linear-gradient(135deg, #007AFF, #0056CC);">F</div>
                        <div class="software-info">
                            <div class="software-name">Figma</div>
                            <div class="software-desc">UI 设计工具</div>
                        </div>
                    </a>
                    <a href="https://www.notion.so" target="_blank" class="software-item">
                        <div class="software-icon" style="background: linear-gradient(135deg, #30D158, #28A745);">N</div>
                        <div class="software-info">
                            <div class="software-name">Notion</div>
                            <div class="software-desc">笔记与知识库</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Contact -->
            <div class="card contact-card">
                <div class="contact-info">
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        alex@example.com
                    </div>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.58 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        +86 138 0000 0000
                    </div>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?=h($location)?>
                    </div>
                </div>
                <div class="copyright">© 2025 <?=h($name)?>. All rights reserved.</div>
            </div>
        </div>
    </div>

    <!-- 微信二维码弹窗 -->
    <div class="modal-overlay" id="wechatModal" onclick="hideWechatModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-title">扫码添加微信</div>
            <div class="qr-code">
                <!--
                    在这里添加你的微信二维码图片
                    将 your-wechat-qrcode.jpg 替换为你的二维码图片路径
                -->
                <!-- <img src="your-wechat-qrcode.jpg" alt="微信二维码" /> -->
                <div class="qr-code-placeholder">点击修改HTML添加二维码图片</div>
            </div>
            <button class="modal-close" onclick="hideWechatModal()">关闭</button>
        </div>
    </div>

    <script>
        // 主题切换功能
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        // 页面加载时恢复主题
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        });

        // 微信弹窗功能
        function showWechatModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            document.getElementById('wechatModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideWechatModal(event) {
            if (event && event.target !== event.currentTarget) {
                return;
            }
            document.getElementById('wechatModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        // 按 ESC 关闭弹窗
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideWechatModal();
            }
        });
    </script>

<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.inland-security-footer {
  position: fixed;
  z-index: 10;
  bottom: 0;
  right: 0;
  width: fit-content;
  display: flex;
  justify-content: flex-end;
}

.tooltip-container {
  position: relative;
}

.trigger-content {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  padding: 8px;
  background-color: transparent;
  border-radius: 8px;
  cursor: pointer;
}

.minimax-link {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-weight: 300;
  color: #adadad;
  text-decoration: none;
}

.minimax-link:visited {
  color: #adadad;
}

.minimax-link:hover {
  color: #666666;
}

.tooltip-content {
  position: absolute;
  bottom: 100%;
  right: 0;
  display: none;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 8px;
  padding-bottom: 16px; /* 8px 内容间距 + 8px 用于鼠标移动的透明区域 */
  font-size: 12px;
  line-height: 17px;
  background-color: #fafafa;
  border-radius: 12px;
  white-space: nowrap;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  color: #171717;
}

/* 创建透明的连接区域，让鼠标可以平滑移动到 tooltip */
.tooltip-content::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  right: 0;
  height: 16px;
}

.tooltip-container:hover .tooltip-content {
  display: flex;
}

.info-section {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 12px;
}

.beian-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #171717;
}

.beian-icon {
  width: 14px;
  height: 14px;
  margin-right: 2px;
}

.underline-text {
  color: #171717;
  text-decoration: underline;
}

.underline-text:hover {
  color: #000000;
}

/* 深色模式支持 */
@media (prefers-color-scheme: dark) {
  .trigger-content {
    background-color: transparent;
  }

  .minimax-link,
  .minimax-link:visited {
    color: #666666;
  }

  .minimax-link:hover {
    color: #adadad;
  }

  .tooltip-content {
    background-color: #262626;
    color: #ededed;
  }

  .beian-link,
  .underline-text {
    color: #ededed;
  }

  .underline-text:hover {
    color: #ffffff;
  }
}

</style>
<div class="inland-security-footer">
  <div class="tooltip-container">
    <div class="trigger-content">
      <a href="https://www.minimaxi.com/" target="_blank" rel="noreferrer" class="minimax-link">
        <span>© 2026 MiniMax</span>
      </a>
    </div>
    <div class="tooltip-content">
      <section class="info-section">
        <span><?=h($SYS['ext']['company'] ?? '')?></span>
      </section>

      <section class="info-section">
        <a class="beian-link" href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=31010402010179" target="_blank" rel="noreferrer">
          <img alt="hailuo-beian-icon" src="https://cdn.hailuoai.com/hailuo-video-web/public_assets/223037d3-79fd-4db0-a456-749f38a6a14b.png" class="beian-icon">
          <span class="underline-text">沪公网安备31010402010179号</span>
        </a>
        <a href="https://beian.miit.gov.cn/" target="_blank" rel="noreferrer" class="underline-text">
          沪ICP备2023003282号-38
        </a>
      </section>

      <section class="info-section">
        <span>模型名称：MiniMax</span>
        <span>备案号：Shanghai-MiniMax-202505230046</span>
      </section>

      <section class="info-section">
        <a href="https://agent.minimaxi.com/doc/zh/terms-of-service.html" target="_blank" rel="noreferrer" class="underline-text">
          用户协议
        </a>
        <a href="https://agent.minimaxi.com/doc/zh/privacy-policy.html" target="_blank" rel="noreferrer" class="underline-text">
          隐私政策
        </a>
      </section>
    </div>
  </div>
</div>


<script>
/**
 * Iframe 元素高亮注入脚本
 * 需要在目标网站中引入此脚本来支持跨域 iframe 高亮功能
 *
 * 使用方法：
 * 1. 将此脚本添加到目标网站的 HTML 中
 * 2. 或通过浏览器扩展、用户脚本等方式注入
 */

(function () {
  "use strict";

  // 检查是否在 iframe 中
  if (window.self === window.top) {
    return; // 不在 iframe 中，不执行
  }

  // 检查是否已经初始化过
  if (window.__iframeHighlightInitialized) {
    return;
  }
  window.__iframeHighlightInitialized = true;
  console.log("Iframe 高亮脚本已加载");

  // 创建高亮覆盖层
  var overlay = document.createElement("div");
  overlay.id = "iframe-highlight-overlay";
  overlay.style.cssText = "\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100vw;\n    height: 100vh;\n    pointer-events: none;\n    z-index: 999999;\n    overflow: hidden;\n  ";

  // 创建悬停高亮框（虚线边框）
  var highlightBox = document.createElement("div");
  highlightBox.id = "iframe-highlight-box";
  highlightBox.style.cssText = "\n    position: absolute;\n    border: 2px dashed #007AFF;\n    background: rgba(0, 122, 255, 0.08);\n    pointer-events: none;\n    display: none;\n    transition: all 0.1s ease;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);\n    border-radius: 2px;\n  ";

  // 创建选中节点的常驻高亮框（实线边框）
  var selectedBox = document.createElement("div");
  selectedBox.id = "iframe-selected-box";
  selectedBox.style.cssText = "\n    position: absolute;\n    border: 2px solid #007AFF;\n    pointer-events: none;\n    display: none;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.9), 0 0 8px rgba(255, 107, 53, 0.4);\n    border-radius: 2px;\n    z-index: 1000000;\n  ";

  // 创建悬停标签显示
  var tagLabel = document.createElement("div");
  tagLabel.id = "iframe-tag-label";
  tagLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 2px 6px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 2px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000001;\n    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);\n    font-weight: 500;\n  ";

  // 创建选中节点标签
  var selectedLabel = document.createElement("div");
  selectedLabel.id = "iframe-selected-label";
  selectedLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 3px 8px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 3px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000002;\n    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);\n    font-weight: 600;\n  ";
  overlay.appendChild(highlightBox);
  overlay.appendChild(selectedBox);
  overlay.appendChild(tagLabel);
  overlay.appendChild(selectedLabel);
  document.body.appendChild(overlay);

  // 存储当前选中的元素
  var selectedElement = null;
  var highlightEnabled = false;

  // 更新选中元素的高亮显示
  function updateSelectedHighlight(element) {
    console.log("updateSelectedHighlight called with:", element);
    if (!element) {
      selectedBox.style.display = "none";
      selectedLabel.style.display = "none";
      selectedElement = null;
      console.log("Cleared selected highlight");
      return;
    }
    selectedElement = element;
    var rect = element.getBoundingClientRect();
    console.log("Selected element rect:", rect);

    // 更新选中高亮框位置
    selectedBox.style.display = "block";
    selectedBox.style.left = "".concat(rect.left - 2, "px");
    selectedBox.style.top = "".concat(rect.top - 2, "px");
    selectedBox.style.width = "".concat(rect.width + 4, "px");
    selectedBox.style.height = "".concat(rect.height + 4, "px");

    // 更新选中标签位置和内容
    selectedLabel.style.display = "block";
    selectedLabel.textContent = "\u2713 <".concat(element.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 28;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 5) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    var labelWidth = selectedLabel.offsetWidth || 100; // 预估宽度
    if (labelLeft + labelWidth > window.innerWidth - 10) {
      labelLeft = window.innerWidth - labelWidth - 10;
    }
    selectedLabel.style.left = "".concat(Math.max(5, labelLeft), "px");
    selectedLabel.style.top = "".concat(labelTop, "px");
    console.log("Selected highlight positioned at:", {
      left: selectedBox.style.left,
      top: selectedBox.style.top,
      width: selectedBox.style.width,
      height: selectedBox.style.height
    });
  }
  function getElementSelector(element) {
    if (!(element instanceof Element)) throw new Error('Argument must be a DOM element');
    var segments = [];
    var current = element;
    while (current !== document.documentElement) {
      var selector = '';
      // 优先检查唯一ID
      if (current.id && document.querySelectorAll("#".concat(current.id)).length === 1) {
        segments.unshift("#".concat(current.id));
        break; // ID唯一，无需继续向上
      }

      // 生成类名选择器（取第一个有效类名）
      var classes = Array.from(current.classList).filter(function (c) {
        return !c.startsWith('js-');
      });
      var className = classes.length > 0 ? ".".concat(classes[0]) : '';

      // 生成位置索引（nth-child）
      var tag = current.tagName.toLowerCase();
      if (!className) {
        var siblings = Array.from(current.parentNode.children);
        var index = siblings.findIndex(function (el) {
          return el === current;
        }) + 1;
        selector = "".concat(tag, ":nth-child(").concat(index, ")");
      } else {
        selector = className;
      }
      segments.unshift(selector);
      current = current.parentElement;
    }

    // 处理根元素
    if (current === document.documentElement) {
      segments.unshift('html');
    }
    return segments.join(' > ');
  }

  // 获取元素文本内容
  function getElementText(element) {
    var _element$textContent;
    if (element.tagName === "INPUT") {
      return element.value || element.placeholder || "";
    }
    if (element.tagName === "TEXTAREA") {
      return element.value || element.placeholder || "";
    }
    var text = ((_element$textContent = element.textContent) === null || _element$textContent === void 0 ? void 0 : _element$textContent.trim()) || "";
    return text.length > 50 ? text.substring(0, 50) + "..." : text;
  }

  // 获取元素属性信息
  function getElementAttributes(element) {
    var attrs = {};
    for (var i = 0; i < element.attributes.length; i++) {
      var attr = element.attributes[i];
      attrs[attr.name] = attr.value;
    }
    return attrs;
  }

  // 鼠标悬停事件处理
  function handleMouseOver(e) {
    if (!highlightEnabled) return;
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免高亮 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 如果是已选中的元素，不显示悬停高亮
    if (target === selectedElement) {
      highlightBox.style.display = "none";
      tagLabel.style.display = "none";
      return;
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);

    // 更新悬停高亮框位置
    highlightBox.style.display = "block";
    highlightBox.style.left = "".concat(rect.left - 2, "px");
    highlightBox.style.top = "".concat(rect.top - 2, "px");
    highlightBox.style.width = "".concat(rect.width + 4, "px");
    highlightBox.style.height = "".concat(rect.height + 4, "px");

    // 更新标签位置和内容
    tagLabel.style.display = "block";
    tagLabel.textContent = "<".concat(target.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 22;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 0) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    if (labelLeft + tagLabel.offsetWidth > window.innerWidth) {
      labelLeft = window.innerWidth - tagLabel.offsetWidth - 5;
    }
    tagLabel.style.left = "".concat(Math.max(0, labelLeft), "px");
    tagLabel.style.top = "".concat(labelTop, "px");

    // 发送消息到父窗口
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 鼠标离开事件处理
  function handleMouseOut(e) {
    if (!highlightEnabled) return;
    var relatedTarget = e.relatedTarget;

    // 如果鼠标移动到高亮相关元素上，不隐藏高亮
    if (relatedTarget && (relatedTarget === highlightBox || relatedTarget === tagLabel || relatedTarget === overlay || relatedTarget === selectedBox || relatedTarget === selectedLabel)) {
      return;
    }
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: null,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 点击事件处理
  function handleClick(e) {
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免处理 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 检查是否是交互元素，这些元素需要保留默认行为
    var isInteractiveElement = ['input', 'textarea', 'select', 'button', 'a'].includes(target.tagName.toLowerCase());

    // 如果高亮功能启用，对于非交互元素阻止默认行为和事件传播
    if (highlightEnabled) {
      e.preventDefault();
      e.stopPropagation();
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);
    console.log("Element clicked:", {
      tagName: target.tagName,
      selector: selector,
      rect: rect
    });

    // 立即更新选中高亮
    updateSelectedHighlight(target);

    // 隐藏悬停高亮，因为现在是选中状态
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-click",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 监听来自父窗口的消息
  function handleParentMessage(event) {
    console.log("Received message from parent:", event.data);
    if (event.data.type === "iframe-highlight-toggle") {
      var enabled = event.data.enabled;
      console.log("Highlight toggle:", enabled);
      if (enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "enable-iframe-highlight") {
      console.log("Enable iframe highlight");
      enableHighlight();
    } else if (event.data.type === "disable-iframe-highlight") {
      console.log("Disable iframe highlight");
      disableHighlight();
    } else if (event.data.type === "toggle-iframe-highlight") {
      var _enabled = event.data.enabled !== undefined ? event.data.enabled : !highlightEnabled;
      console.log("Toggle iframe highlight to:", _enabled);
      if (_enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "update-selected-element") {
      var selector = event.data.selector;
      console.log("Update selected element with selector:", selector);
      if (selector) {
        try {
          var element = document.querySelector(selector);
          console.log("Found element by selector:", element);
          updateSelectedHighlight(element);
        } catch (error) {
          console.warn("Failed to select element:", error);
          updateSelectedHighlight(null);
        }
      } else {
        updateSelectedHighlight(null);
      }
    } else if (event.data.type === "clear-selected-element") {
      console.log("Clear selected element");
      updateSelectedHighlight(null);
    }
  }

  // 启用高亮功能
  function enableHighlight() {
    console.log("Enabling highlight");
    document.addEventListener("mouseover", handleMouseOver, true);
    document.addEventListener("mouseout", handleMouseOut, true);
    document.addEventListener("click", handleClick, true);
    highlightEnabled = true;
    overlay.style.display = "block";
  }

  // 禁用高亮功能
  function disableHighlight() {
    console.log("Disabling highlight");
    highlightEnabled = false;
    // 保持事件监听器，但通过 highlightEnabled 变量控制行为
    // 这样可以保留选中状态的显示
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    // 不隐藏 selectedBox 和 selectedLabel，保留选中状态
  }

  // 完全禁用高亮功能（移除所有监听器）
  function fullyDisableHighlight() {
    console.log("Fully disabling highlight");
    highlightEnabled = false;
    document.removeEventListener("mouseover", handleMouseOver, true);
    document.removeEventListener("mouseout", handleMouseOut, true);
    document.removeEventListener("click", handleClick, true);
    overlay.style.display = "none";
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    selectedBox.style.display = "none";
    selectedLabel.style.display = "none";
  }

  // 添加事件监听
  enableHighlight();
  window.addEventListener("message", handleParentMessage);

  // 暴露全局函数供外部调用
  window.__iframeHighlightControl = {
    enable: enableHighlight,
    disable: disableHighlight,
    fullyDisable: fullyDisableHighlight,
    isEnabled: function isEnabled() {
      return highlightEnabled;
    },
    getSelectedElement: function getSelectedElement() {
      return selectedElement;
    },
    updateSelected: updateSelectedHighlight,
    // 通过消息发送开关控制
    sendToggleMessage: function sendToggleMessage(enabled) {
      window.parent.postMessage({
        type: 'iframe-highlight-status',
        enabled: enabled || highlightEnabled,
        source: 'iframe-highlight-injector'
      }, '*');
    }
  };

  // 通知父窗口脚本已加载
  try {
    window.parent.postMessage({
      type: "iframe-highlight-ready",
      data: {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: Date.now()
      },
      source: "iframe-highlight-injector"
    }, "*");
  } catch (error) {
    console.warn("无法发送就绪消息到父窗口:", error);
  }

  // 清理函数
  window.__iframeHighlightCleanup = function () {
    fullyDisableHighlight();
    window.removeEventListener("message", handleParentMessage);
    if (overlay.parentElement) {
      overlay.parentElement.removeChild(overlay);
    }
    delete window.__iframeHighlightInitialized;
    delete window.__iframeHighlightCleanup;
  };
})();

</script>

<script>
/**
 * Iframe 元素高亮注入脚本
 * 需要在目标网站中引入此脚本来支持跨域 iframe 高亮功能
 *
 * 使用方法：
 * 1. 将此脚本添加到目标网站的 HTML 中
 * 2. 或通过浏览器扩展、用户脚本等方式注入
 */

(function () {
  "use strict";

  // 检查是否在 iframe 中
  if (window.self === window.top) {
    return; // 不在 iframe 中，不执行
  }

  // 检查是否已经初始化过
  if (window.__iframeHighlightInitialized) {
    return;
  }
  window.__iframeHighlightInitialized = true;
  console.log("Iframe 高亮脚本已加载");

  // 创建高亮覆盖层
  var overlay = document.createElement("div");
  overlay.id = "iframe-highlight-overlay";
  overlay.style.cssText = "\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100vw;\n    height: 100vh;\n    pointer-events: none;\n    z-index: 999999;\n    overflow: hidden;\n  ";

  // 创建悬停高亮框（虚线边框）
  var highlightBox = document.createElement("div");
  highlightBox.id = "iframe-highlight-box";
  highlightBox.style.cssText = "\n    position: absolute;\n    border: 2px dashed #007AFF;\n    background: rgba(0, 122, 255, 0.08);\n    pointer-events: none;\n    display: none;\n    transition: all 0.1s ease;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);\n    border-radius: 2px;\n  ";

  // 创建选中节点的常驻高亮框（实线边框）
  var selectedBox = document.createElement("div");
  selectedBox.id = "iframe-selected-box";
  selectedBox.style.cssText = "\n    position: absolute;\n    border: 2px solid #007AFF;\n    pointer-events: none;\n    display: none;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.9), 0 0 8px rgba(255, 107, 53, 0.4);\n    border-radius: 2px;\n    z-index: 1000000;\n  ";

  // 创建悬停标签显示
  var tagLabel = document.createElement("div");
  tagLabel.id = "iframe-tag-label";
  tagLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 2px 6px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 2px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000001;\n    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);\n    font-weight: 500;\n  ";

  // 创建选中节点标签
  var selectedLabel = document.createElement("div");
  selectedLabel.id = "iframe-selected-label";
  selectedLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 3px 8px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 3px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000002;\n    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);\n    font-weight: 600;\n  ";
  overlay.appendChild(highlightBox);
  overlay.appendChild(selectedBox);
  overlay.appendChild(tagLabel);
  overlay.appendChild(selectedLabel);
  document.body.appendChild(overlay);

  // 存储当前选中的元素
  var selectedElement = null;
  var highlightEnabled = false;

  // 更新选中元素的高亮显示
  function updateSelectedHighlight(element) {
    console.log("updateSelectedHighlight called with:", element);
    if (!element) {
      selectedBox.style.display = "none";
      selectedLabel.style.display = "none";
      selectedElement = null;
      console.log("Cleared selected highlight");
      return;
    }
    selectedElement = element;
    var rect = element.getBoundingClientRect();
    console.log("Selected element rect:", rect);

    // 更新选中高亮框位置
    selectedBox.style.display = "block";
    selectedBox.style.left = "".concat(rect.left - 2, "px");
    selectedBox.style.top = "".concat(rect.top - 2, "px");
    selectedBox.style.width = "".concat(rect.width + 4, "px");
    selectedBox.style.height = "".concat(rect.height + 4, "px");

    // 更新选中标签位置和内容
    selectedLabel.style.display = "block";
    selectedLabel.textContent = "\u2713 <".concat(element.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 28;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 5) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    var labelWidth = selectedLabel.offsetWidth || 100; // 预估宽度
    if (labelLeft + labelWidth > window.innerWidth - 10) {
      labelLeft = window.innerWidth - labelWidth - 10;
    }
    selectedLabel.style.left = "".concat(Math.max(5, labelLeft), "px");
    selectedLabel.style.top = "".concat(labelTop, "px");
    console.log("Selected highlight positioned at:", {
      left: selectedBox.style.left,
      top: selectedBox.style.top,
      width: selectedBox.style.width,
      height: selectedBox.style.height
    });
  }
  function getElementSelector(element) {
    if (!(element instanceof Element)) throw new Error('Argument must be a DOM element');
    var segments = [];
    var current = element;
    while (current !== document.documentElement) {
      var selector = '';
      // 优先检查唯一ID
      if (current.id && document.querySelectorAll("#".concat(current.id)).length === 1) {
        segments.unshift("#".concat(current.id));
        break; // ID唯一，无需继续向上
      }

      // 生成类名选择器（取第一个有效类名）
      var classes = Array.from(current.classList).filter(function (c) {
        return !c.startsWith('js-');
      });
      var className = classes.length > 0 ? ".".concat(classes[0]) : '';

      // 生成位置索引（nth-child）
      var tag = current.tagName.toLowerCase();
      if (!className) {
        var siblings = Array.from(current.parentNode.children);
        var index = siblings.findIndex(function (el) {
          return el === current;
        }) + 1;
        selector = "".concat(tag, ":nth-child(").concat(index, ")");
      } else {
        selector = className;
      }
      segments.unshift(selector);
      current = current.parentElement;
    }

    // 处理根元素
    if (current === document.documentElement) {
      segments.unshift('html');
    }
    return segments.join(' > ');
  }

  // 获取元素文本内容
  function getElementText(element) {
    var _element$textContent;
    if (element.tagName === "INPUT") {
      return element.value || element.placeholder || "";
    }
    if (element.tagName === "TEXTAREA") {
      return element.value || element.placeholder || "";
    }
    var text = ((_element$textContent = element.textContent) === null || _element$textContent === void 0 ? void 0 : _element$textContent.trim()) || "";
    return text.length > 50 ? text.substring(0, 50) + "..." : text;
  }

  // 获取元素属性信息
  function getElementAttributes(element) {
    var attrs = {};
    for (var i = 0; i < element.attributes.length; i++) {
      var attr = element.attributes[i];
      attrs[attr.name] = attr.value;
    }
    return attrs;
  }

  // 鼠标悬停事件处理
  function handleMouseOver(e) {
    if (!highlightEnabled) return;
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免高亮 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 如果是已选中的元素，不显示悬停高亮
    if (target === selectedElement) {
      highlightBox.style.display = "none";
      tagLabel.style.display = "none";
      return;
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);

    // 更新悬停高亮框位置
    highlightBox.style.display = "block";
    highlightBox.style.left = "".concat(rect.left - 2, "px");
    highlightBox.style.top = "".concat(rect.top - 2, "px");
    highlightBox.style.width = "".concat(rect.width + 4, "px");
    highlightBox.style.height = "".concat(rect.height + 4, "px");

    // 更新标签位置和内容
    tagLabel.style.display = "block";
    tagLabel.textContent = "<".concat(target.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 22;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 0) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    if (labelLeft + tagLabel.offsetWidth > window.innerWidth) {
      labelLeft = window.innerWidth - tagLabel.offsetWidth - 5;
    }
    tagLabel.style.left = "".concat(Math.max(0, labelLeft), "px");
    tagLabel.style.top = "".concat(labelTop, "px");

    // 发送消息到父窗口
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 鼠标离开事件处理
  function handleMouseOut(e) {
    if (!highlightEnabled) return;
    var relatedTarget = e.relatedTarget;

    // 如果鼠标移动到高亮相关元素上，不隐藏高亮
    if (relatedTarget && (relatedTarget === highlightBox || relatedTarget === tagLabel || relatedTarget === overlay || relatedTarget === selectedBox || relatedTarget === selectedLabel)) {
      return;
    }
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: null,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 点击事件处理
  function handleClick(e) {
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免处理 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 检查是否是交互元素，这些元素需要保留默认行为
    var isInteractiveElement = ['input', 'textarea', 'select', 'button', 'a'].includes(target.tagName.toLowerCase());

    // 如果高亮功能启用，对于非交互元素阻止默认行为和事件传播
    if (highlightEnabled) {
      e.preventDefault();
      e.stopPropagation();
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);
    console.log("Element clicked:", {
      tagName: target.tagName,
      selector: selector,
      rect: rect
    });

    // 立即更新选中高亮
    updateSelectedHighlight(target);

    // 隐藏悬停高亮，因为现在是选中状态
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-click",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 监听来自父窗口的消息
  function handleParentMessage(event) {
    console.log("Received message from parent:", event.data);
    if (event.data.type === "iframe-highlight-toggle") {
      var enabled = event.data.enabled;
      console.log("Highlight toggle:", enabled);
      if (enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "enable-iframe-highlight") {
      console.log("Enable iframe highlight");
      enableHighlight();
    } else if (event.data.type === "disable-iframe-highlight") {
      console.log("Disable iframe highlight");
      disableHighlight();
    } else if (event.data.type === "toggle-iframe-highlight") {
      var _enabled = event.data.enabled !== undefined ? event.data.enabled : !highlightEnabled;
      console.log("Toggle iframe highlight to:", _enabled);
      if (_enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "update-selected-element") {
      var selector = event.data.selector;
      console.log("Update selected element with selector:", selector);
      if (selector) {
        try {
          var element = document.querySelector(selector);
          console.log("Found element by selector:", element);
          updateSelectedHighlight(element);
        } catch (error) {
          console.warn("Failed to select element:", error);
          updateSelectedHighlight(null);
        }
      } else {
        updateSelectedHighlight(null);
      }
    } else if (event.data.type === "clear-selected-element") {
      console.log("Clear selected element");
      updateSelectedHighlight(null);
    }
  }

  // 启用高亮功能
  function enableHighlight() {
    console.log("Enabling highlight");
    document.addEventListener("mouseover", handleMouseOver, true);
    document.addEventListener("mouseout", handleMouseOut, true);
    document.addEventListener("click", handleClick, true);
    highlightEnabled = true;
    overlay.style.display = "block";
  }

  // 禁用高亮功能
  function disableHighlight() {
    console.log("Disabling highlight");
    highlightEnabled = false;
    // 保持事件监听器，但通过 highlightEnabled 变量控制行为
    // 这样可以保留选中状态的显示
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    // 不隐藏 selectedBox 和 selectedLabel，保留选中状态
  }

  // 完全禁用高亮功能（移除所有监听器）
  function fullyDisableHighlight() {
    console.log("Fully disabling highlight");
    highlightEnabled = false;
    document.removeEventListener("mouseover", handleMouseOver, true);
    document.removeEventListener("mouseout", handleMouseOut, true);
    document.removeEventListener("click", handleClick, true);
    overlay.style.display = "none";
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    selectedBox.style.display = "none";
    selectedLabel.style.display = "none";
  }

  // 添加事件监听
  enableHighlight();
  window.addEventListener("message", handleParentMessage);

  // 暴露全局函数供外部调用
  window.__iframeHighlightControl = {
    enable: enableHighlight,
    disable: disableHighlight,
    fullyDisable: fullyDisableHighlight,
    isEnabled: function isEnabled() {
      return highlightEnabled;
    },
    getSelectedElement: function getSelectedElement() {
      return selectedElement;
    },
    updateSelected: updateSelectedHighlight,
    // 通过消息发送开关控制
    sendToggleMessage: function sendToggleMessage(enabled) {
      window.parent.postMessage({
        type: 'iframe-highlight-status',
        enabled: enabled || highlightEnabled,
        source: 'iframe-highlight-injector'
      }, '*');
    }
  };

  // 通知父窗口脚本已加载
  try {
    window.parent.postMessage({
      type: "iframe-highlight-ready",
      data: {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: Date.now()
      },
      source: "iframe-highlight-injector"
    }, "*");
  } catch (error) {
    console.warn("无法发送就绪消息到父窗口:", error);
  }

  // 清理函数
  window.__iframeHighlightCleanup = function () {
    fullyDisableHighlight();
    window.removeEventListener("message", handleParentMessage);
    if (overlay.parentElement) {
      overlay.parentElement.removeChild(overlay);
    }
    delete window.__iframeHighlightInitialized;
    delete window.__iframeHighlightCleanup;
  };
})();

</script>

<script>
/**
 * Iframe 元素高亮注入脚本
 * 需要在目标网站中引入此脚本来支持跨域 iframe 高亮功能
 *
 * 使用方法：
 * 1. 将此脚本添加到目标网站的 HTML 中
 * 2. 或通过浏览器扩展、用户脚本等方式注入
 */

(function () {
  "use strict";

  // 检查是否在 iframe 中
  if (window.self === window.top) {
    return; // 不在 iframe 中，不执行
  }

  // 检查是否已经初始化过
  if (window.__iframeHighlightInitialized) {
    return;
  }
  window.__iframeHighlightInitialized = true;
  console.log("Iframe 高亮脚本已加载");

  // 创建高亮覆盖层
  var overlay = document.createElement("div");
  overlay.id = "iframe-highlight-overlay";
  overlay.style.cssText = "\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100vw;\n    height: 100vh;\n    pointer-events: none;\n    z-index: 999999;\n    overflow: hidden;\n  ";

  // 创建悬停高亮框（虚线边框）
  var highlightBox = document.createElement("div");
  highlightBox.id = "iframe-highlight-box";
  highlightBox.style.cssText = "\n    position: absolute;\n    border: 2px dashed #007AFF;\n    background: rgba(0, 122, 255, 0.08);\n    pointer-events: none;\n    display: none;\n    transition: all 0.1s ease;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);\n    border-radius: 2px;\n  ";

  // 创建选中节点的常驻高亮框（实线边框）
  var selectedBox = document.createElement("div");
  selectedBox.id = "iframe-selected-box";
  selectedBox.style.cssText = "\n    position: absolute;\n    border: 2px solid #007AFF;\n    pointer-events: none;\n    display: none;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.9), 0 0 8px rgba(255, 107, 53, 0.4);\n    border-radius: 2px;\n    z-index: 1000000;\n  ";

  // 创建悬停标签显示
  var tagLabel = document.createElement("div");
  tagLabel.id = "iframe-tag-label";
  tagLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 2px 6px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 2px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000001;\n    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);\n    font-weight: 500;\n  ";

  // 创建选中节点标签
  var selectedLabel = document.createElement("div");
  selectedLabel.id = "iframe-selected-label";
  selectedLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 3px 8px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 3px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000002;\n    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);\n    font-weight: 600;\n  ";
  overlay.appendChild(highlightBox);
  overlay.appendChild(selectedBox);
  overlay.appendChild(tagLabel);
  overlay.appendChild(selectedLabel);
  document.body.appendChild(overlay);

  // 存储当前选中的元素
  var selectedElement = null;
  var highlightEnabled = false;

  // 更新选中元素的高亮显示
  function updateSelectedHighlight(element) {
    console.log("updateSelectedHighlight called with:", element);
    if (!element) {
      selectedBox.style.display = "none";
      selectedLabel.style.display = "none";
      selectedElement = null;
      console.log("Cleared selected highlight");
      return;
    }
    selectedElement = element;
    var rect = element.getBoundingClientRect();
    console.log("Selected element rect:", rect);

    // 更新选中高亮框位置
    selectedBox.style.display = "block";
    selectedBox.style.left = "".concat(rect.left - 2, "px");
    selectedBox.style.top = "".concat(rect.top - 2, "px");
    selectedBox.style.width = "".concat(rect.width + 4, "px");
    selectedBox.style.height = "".concat(rect.height + 4, "px");

    // 更新选中标签位置和内容
    selectedLabel.style.display = "block";
    selectedLabel.textContent = "\u2713 <".concat(element.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 28;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 5) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    var labelWidth = selectedLabel.offsetWidth || 100; // 预估宽度
    if (labelLeft + labelWidth > window.innerWidth - 10) {
      labelLeft = window.innerWidth - labelWidth - 10;
    }
    selectedLabel.style.left = "".concat(Math.max(5, labelLeft), "px");
    selectedLabel.style.top = "".concat(labelTop, "px");
    console.log("Selected highlight positioned at:", {
      left: selectedBox.style.left,
      top: selectedBox.style.top,
      width: selectedBox.style.width,
      height: selectedBox.style.height
    });
  }
  function getElementSelector(element) {
    if (!(element instanceof Element)) throw new Error('Argument must be a DOM element');
    var segments = [];
    var current = element;
    while (current !== document.documentElement) {
      var selector = '';
      // 优先检查唯一ID
      if (current.id && document.querySelectorAll("#".concat(current.id)).length === 1) {
        segments.unshift("#".concat(current.id));
        break; // ID唯一，无需继续向上
      }

      // 生成类名选择器（取第一个有效类名）
      var classes = Array.from(current.classList).filter(function (c) {
        return !c.startsWith('js-');
      });
      var className = classes.length > 0 ? ".".concat(classes[0]) : '';

      // 生成位置索引（nth-child）
      var tag = current.tagName.toLowerCase();
      if (!className) {
        var siblings = Array.from(current.parentNode.children);
        var index = siblings.findIndex(function (el) {
          return el === current;
        }) + 1;
        selector = "".concat(tag, ":nth-child(").concat(index, ")");
      } else {
        selector = className;
      }
      segments.unshift(selector);
      current = current.parentElement;
    }

    // 处理根元素
    if (current === document.documentElement) {
      segments.unshift('html');
    }
    return segments.join(' > ');
  }

  // 获取元素文本内容
  function getElementText(element) {
    var _element$textContent;
    if (element.tagName === "INPUT") {
      return element.value || element.placeholder || "";
    }
    if (element.tagName === "TEXTAREA") {
      return element.value || element.placeholder || "";
    }
    var text = ((_element$textContent = element.textContent) === null || _element$textContent === void 0 ? void 0 : _element$textContent.trim()) || "";
    return text.length > 50 ? text.substring(0, 50) + "..." : text;
  }

  // 获取元素属性信息
  function getElementAttributes(element) {
    var attrs = {};
    for (var i = 0; i < element.attributes.length; i++) {
      var attr = element.attributes[i];
      attrs[attr.name] = attr.value;
    }
    return attrs;
  }

  // 鼠标悬停事件处理
  function handleMouseOver(e) {
    if (!highlightEnabled) return;
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免高亮 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 如果是已选中的元素，不显示悬停高亮
    if (target === selectedElement) {
      highlightBox.style.display = "none";
      tagLabel.style.display = "none";
      return;
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);

    // 更新悬停高亮框位置
    highlightBox.style.display = "block";
    highlightBox.style.left = "".concat(rect.left - 2, "px");
    highlightBox.style.top = "".concat(rect.top - 2, "px");
    highlightBox.style.width = "".concat(rect.width + 4, "px");
    highlightBox.style.height = "".concat(rect.height + 4, "px");

    // 更新标签位置和内容
    tagLabel.style.display = "block";
    tagLabel.textContent = "<".concat(target.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 22;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 0) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    if (labelLeft + tagLabel.offsetWidth > window.innerWidth) {
      labelLeft = window.innerWidth - tagLabel.offsetWidth - 5;
    }
    tagLabel.style.left = "".concat(Math.max(0, labelLeft), "px");
    tagLabel.style.top = "".concat(labelTop, "px");

    // 发送消息到父窗口
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 鼠标离开事件处理
  function handleMouseOut(e) {
    if (!highlightEnabled) return;
    var relatedTarget = e.relatedTarget;

    // 如果鼠标移动到高亮相关元素上，不隐藏高亮
    if (relatedTarget && (relatedTarget === highlightBox || relatedTarget === tagLabel || relatedTarget === overlay || relatedTarget === selectedBox || relatedTarget === selectedLabel)) {
      return;
    }
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: null,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 点击事件处理
  function handleClick(e) {
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免处理 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 检查是否是交互元素，这些元素需要保留默认行为
    var isInteractiveElement = ['input', 'textarea', 'select', 'button', 'a'].includes(target.tagName.toLowerCase());

    // 如果高亮功能启用，对于非交互元素阻止默认行为和事件传播
    if (highlightEnabled) {
      e.preventDefault();
      e.stopPropagation();
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);
    console.log("Element clicked:", {
      tagName: target.tagName,
      selector: selector,
      rect: rect
    });

    // 立即更新选中高亮
    updateSelectedHighlight(target);

    // 隐藏悬停高亮，因为现在是选中状态
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-click",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 监听来自父窗口的消息
  function handleParentMessage(event) {
    console.log("Received message from parent:", event.data);
    if (event.data.type === "iframe-highlight-toggle") {
      var enabled = event.data.enabled;
      console.log("Highlight toggle:", enabled);
      if (enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "enable-iframe-highlight") {
      console.log("Enable iframe highlight");
      enableHighlight();
    } else if (event.data.type === "disable-iframe-highlight") {
      console.log("Disable iframe highlight");
      disableHighlight();
    } else if (event.data.type === "toggle-iframe-highlight") {
      var _enabled = event.data.enabled !== undefined ? event.data.enabled : !highlightEnabled;
      console.log("Toggle iframe highlight to:", _enabled);
      if (_enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "update-selected-element") {
      var selector = event.data.selector;
      console.log("Update selected element with selector:", selector);
      if (selector) {
        try {
          var element = document.querySelector(selector);
          console.log("Found element by selector:", element);
          updateSelectedHighlight(element);
        } catch (error) {
          console.warn("Failed to select element:", error);
          updateSelectedHighlight(null);
        }
      } else {
        updateSelectedHighlight(null);
      }
    } else if (event.data.type === "clear-selected-element") {
      console.log("Clear selected element");
      updateSelectedHighlight(null);
    }
  }

  // 启用高亮功能
  function enableHighlight() {
    console.log("Enabling highlight");
    document.addEventListener("mouseover", handleMouseOver, true);
    document.addEventListener("mouseout", handleMouseOut, true);
    document.addEventListener("click", handleClick, true);
    highlightEnabled = true;
    overlay.style.display = "block";
  }

  // 禁用高亮功能
  function disableHighlight() {
    console.log("Disabling highlight");
    highlightEnabled = false;
    // 保持事件监听器，但通过 highlightEnabled 变量控制行为
    // 这样可以保留选中状态的显示
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    // 不隐藏 selectedBox 和 selectedLabel，保留选中状态
  }

  // 完全禁用高亮功能（移除所有监听器）
  function fullyDisableHighlight() {
    console.log("Fully disabling highlight");
    highlightEnabled = false;
    document.removeEventListener("mouseover", handleMouseOver, true);
    document.removeEventListener("mouseout", handleMouseOut, true);
    document.removeEventListener("click", handleClick, true);
    overlay.style.display = "none";
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    selectedBox.style.display = "none";
    selectedLabel.style.display = "none";
  }

  // 添加事件监听
  enableHighlight();
  window.addEventListener("message", handleParentMessage);

  // 暴露全局函数供外部调用
  window.__iframeHighlightControl = {
    enable: enableHighlight,
    disable: disableHighlight,
    fullyDisable: fullyDisableHighlight,
    isEnabled: function isEnabled() {
      return highlightEnabled;
    },
    getSelectedElement: function getSelectedElement() {
      return selectedElement;
    },
    updateSelected: updateSelectedHighlight,
    // 通过消息发送开关控制
    sendToggleMessage: function sendToggleMessage(enabled) {
      window.parent.postMessage({
        type: 'iframe-highlight-status',
        enabled: enabled || highlightEnabled,
        source: 'iframe-highlight-injector'
      }, '*');
    }
  };

  // 通知父窗口脚本已加载
  try {
    window.parent.postMessage({
      type: "iframe-highlight-ready",
      data: {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: Date.now()
      },
      source: "iframe-highlight-injector"
    }, "*");
  } catch (error) {
    console.warn("无法发送就绪消息到父窗口:", error);
  }

  // 清理函数
  window.__iframeHighlightCleanup = function () {
    fullyDisableHighlight();
    window.removeEventListener("message", handleParentMessage);
    if (overlay.parentElement) {
      overlay.parentElement.removeChild(overlay);
    }
    delete window.__iframeHighlightInitialized;
    delete window.__iframeHighlightCleanup;
  };
})();

</script>

<script>
/**
 * Iframe 元素高亮注入脚本
 * 需要在目标网站中引入此脚本来支持跨域 iframe 高亮功能
 *
 * 使用方法：
 * 1. 将此脚本添加到目标网站的 HTML 中
 * 2. 或通过浏览器扩展、用户脚本等方式注入
 */

(function () {
  "use strict";

  // 检查是否在 iframe 中
  if (window.self === window.top) {
    return; // 不在 iframe 中，不执行
  }

  // 检查是否已经初始化过
  if (window.__iframeHighlightInitialized) {
    return;
  }
  window.__iframeHighlightInitialized = true;
  console.log("Iframe 高亮脚本已加载");

  // 创建高亮覆盖层
  var overlay = document.createElement("div");
  overlay.id = "iframe-highlight-overlay";
  overlay.style.cssText = "\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100vw;\n    height: 100vh;\n    pointer-events: none;\n    z-index: 999999;\n    overflow: hidden;\n  ";

  // 创建悬停高亮框（虚线边框）
  var highlightBox = document.createElement("div");
  highlightBox.id = "iframe-highlight-box";
  highlightBox.style.cssText = "\n    position: absolute;\n    border: 2px dashed #007AFF;\n    background: rgba(0, 122, 255, 0.08);\n    pointer-events: none;\n    display: none;\n    transition: all 0.1s ease;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);\n    border-radius: 2px;\n  ";

  // 创建选中节点的常驻高亮框（实线边框）
  var selectedBox = document.createElement("div");
  selectedBox.id = "iframe-selected-box";
  selectedBox.style.cssText = "\n    position: absolute;\n    border: 2px solid #007AFF;\n    pointer-events: none;\n    display: none;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.9), 0 0 8px rgba(255, 107, 53, 0.4);\n    border-radius: 2px;\n    z-index: 1000000;\n  ";

  // 创建悬停标签显示
  var tagLabel = document.createElement("div");
  tagLabel.id = "iframe-tag-label";
  tagLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 2px 6px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 2px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000001;\n    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);\n    font-weight: 500;\n  ";

  // 创建选中节点标签
  var selectedLabel = document.createElement("div");
  selectedLabel.id = "iframe-selected-label";
  selectedLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 3px 8px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 3px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000002;\n    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);\n    font-weight: 600;\n  ";
  overlay.appendChild(highlightBox);
  overlay.appendChild(selectedBox);
  overlay.appendChild(tagLabel);
  overlay.appendChild(selectedLabel);
  document.body.appendChild(overlay);

  // 存储当前选中的元素
  var selectedElement = null;
  var highlightEnabled = false;

  // 更新选中元素的高亮显示
  function updateSelectedHighlight(element) {
    console.log("updateSelectedHighlight called with:", element);
    if (!element) {
      selectedBox.style.display = "none";
      selectedLabel.style.display = "none";
      selectedElement = null;
      console.log("Cleared selected highlight");
      return;
    }
    selectedElement = element;
    var rect = element.getBoundingClientRect();
    console.log("Selected element rect:", rect);

    // 更新选中高亮框位置
    selectedBox.style.display = "block";
    selectedBox.style.left = "".concat(rect.left - 2, "px");
    selectedBox.style.top = "".concat(rect.top - 2, "px");
    selectedBox.style.width = "".concat(rect.width + 4, "px");
    selectedBox.style.height = "".concat(rect.height + 4, "px");

    // 更新选中标签位置和内容
    selectedLabel.style.display = "block";
    selectedLabel.textContent = "\u2713 <".concat(element.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 28;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 5) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    var labelWidth = selectedLabel.offsetWidth || 100; // 预估宽度
    if (labelLeft + labelWidth > window.innerWidth - 10) {
      labelLeft = window.innerWidth - labelWidth - 10;
    }
    selectedLabel.style.left = "".concat(Math.max(5, labelLeft), "px");
    selectedLabel.style.top = "".concat(labelTop, "px");
    console.log("Selected highlight positioned at:", {
      left: selectedBox.style.left,
      top: selectedBox.style.top,
      width: selectedBox.style.width,
      height: selectedBox.style.height
    });
  }
  function getElementSelector(element) {
    if (!(element instanceof Element)) throw new Error('Argument must be a DOM element');
    var segments = [];
    var current = element;
    while (current !== document.documentElement) {
      var selector = '';
      // 优先检查唯一ID
      if (current.id && document.querySelectorAll("#".concat(current.id)).length === 1) {
        segments.unshift("#".concat(current.id));
        break; // ID唯一，无需继续向上
      }

      // 生成类名选择器（取第一个有效类名）
      var classes = Array.from(current.classList).filter(function (c) {
        return !c.startsWith('js-');
      });
      var className = classes.length > 0 ? ".".concat(classes[0]) : '';

      // 生成位置索引（nth-child）
      var tag = current.tagName.toLowerCase();
      if (!className) {
        var siblings = Array.from(current.parentNode.children);
        var index = siblings.findIndex(function (el) {
          return el === current;
        }) + 1;
        selector = "".concat(tag, ":nth-child(").concat(index, ")");
      } else {
        selector = className;
      }
      segments.unshift(selector);
      current = current.parentElement;
    }

    // 处理根元素
    if (current === document.documentElement) {
      segments.unshift('html');
    }
    return segments.join(' > ');
  }

  // 获取元素文本内容
  function getElementText(element) {
    var _element$textContent;
    if (element.tagName === "INPUT") {
      return element.value || element.placeholder || "";
    }
    if (element.tagName === "TEXTAREA") {
      return element.value || element.placeholder || "";
    }
    var text = ((_element$textContent = element.textContent) === null || _element$textContent === void 0 ? void 0 : _element$textContent.trim()) || "";
    return text.length > 50 ? text.substring(0, 50) + "..." : text;
  }

  // 获取元素属性信息
  function getElementAttributes(element) {
    var attrs = {};
    for (var i = 0; i < element.attributes.length; i++) {
      var attr = element.attributes[i];
      attrs[attr.name] = attr.value;
    }
    return attrs;
  }

  // 鼠标悬停事件处理
  function handleMouseOver(e) {
    if (!highlightEnabled) return;
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免高亮 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 如果是已选中的元素，不显示悬停高亮
    if (target === selectedElement) {
      highlightBox.style.display = "none";
      tagLabel.style.display = "none";
      return;
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);

    // 更新悬停高亮框位置
    highlightBox.style.display = "block";
    highlightBox.style.left = "".concat(rect.left - 2, "px");
    highlightBox.style.top = "".concat(rect.top - 2, "px");
    highlightBox.style.width = "".concat(rect.width + 4, "px");
    highlightBox.style.height = "".concat(rect.height + 4, "px");

    // 更新标签位置和内容
    tagLabel.style.display = "block";
    tagLabel.textContent = "<".concat(target.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 22;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 0) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    if (labelLeft + tagLabel.offsetWidth > window.innerWidth) {
      labelLeft = window.innerWidth - tagLabel.offsetWidth - 5;
    }
    tagLabel.style.left = "".concat(Math.max(0, labelLeft), "px");
    tagLabel.style.top = "".concat(labelTop, "px");

    // 发送消息到父窗口
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 鼠标离开事件处理
  function handleMouseOut(e) {
    if (!highlightEnabled) return;
    var relatedTarget = e.relatedTarget;

    // 如果鼠标移动到高亮相关元素上，不隐藏高亮
    if (relatedTarget && (relatedTarget === highlightBox || relatedTarget === tagLabel || relatedTarget === overlay || relatedTarget === selectedBox || relatedTarget === selectedLabel)) {
      return;
    }
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: null,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 点击事件处理
  function handleClick(e) {
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免处理 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 检查是否是交互元素，这些元素需要保留默认行为
    var isInteractiveElement = ['input', 'textarea', 'select', 'button', 'a'].includes(target.tagName.toLowerCase());

    // 如果高亮功能启用，对于非交互元素阻止默认行为和事件传播
    if (highlightEnabled) {
      e.preventDefault();
      e.stopPropagation();
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);
    console.log("Element clicked:", {
      tagName: target.tagName,
      selector: selector,
      rect: rect
    });

    // 立即更新选中高亮
    updateSelectedHighlight(target);

    // 隐藏悬停高亮，因为现在是选中状态
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-click",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 监听来自父窗口的消息
  function handleParentMessage(event) {
    console.log("Received message from parent:", event.data);
    if (event.data.type === "iframe-highlight-toggle") {
      var enabled = event.data.enabled;
      console.log("Highlight toggle:", enabled);
      if (enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "enable-iframe-highlight") {
      console.log("Enable iframe highlight");
      enableHighlight();
    } else if (event.data.type === "disable-iframe-highlight") {
      console.log("Disable iframe highlight");
      disableHighlight();
    } else if (event.data.type === "toggle-iframe-highlight") {
      var _enabled = event.data.enabled !== undefined ? event.data.enabled : !highlightEnabled;
      console.log("Toggle iframe highlight to:", _enabled);
      if (_enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "update-selected-element") {
      var selector = event.data.selector;
      console.log("Update selected element with selector:", selector);
      if (selector) {
        try {
          var element = document.querySelector(selector);
          console.log("Found element by selector:", element);
          updateSelectedHighlight(element);
        } catch (error) {
          console.warn("Failed to select element:", error);
          updateSelectedHighlight(null);
        }
      } else {
        updateSelectedHighlight(null);
      }
    } else if (event.data.type === "clear-selected-element") {
      console.log("Clear selected element");
      updateSelectedHighlight(null);
    }
  }

  // 启用高亮功能
  function enableHighlight() {
    console.log("Enabling highlight");
    document.addEventListener("mouseover", handleMouseOver, true);
    document.addEventListener("mouseout", handleMouseOut, true);
    document.addEventListener("click", handleClick, true);
    highlightEnabled = true;
    overlay.style.display = "block";
  }

  // 禁用高亮功能
  function disableHighlight() {
    console.log("Disabling highlight");
    highlightEnabled = false;
    // 保持事件监听器，但通过 highlightEnabled 变量控制行为
    // 这样可以保留选中状态的显示
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    // 不隐藏 selectedBox 和 selectedLabel，保留选中状态
  }

  // 完全禁用高亮功能（移除所有监听器）
  function fullyDisableHighlight() {
    console.log("Fully disabling highlight");
    highlightEnabled = false;
    document.removeEventListener("mouseover", handleMouseOver, true);
    document.removeEventListener("mouseout", handleMouseOut, true);
    document.removeEventListener("click", handleClick, true);
    overlay.style.display = "none";
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    selectedBox.style.display = "none";
    selectedLabel.style.display = "none";
  }

  // 添加事件监听
  enableHighlight();
  window.addEventListener("message", handleParentMessage);

  // 暴露全局函数供外部调用
  window.__iframeHighlightControl = {
    enable: enableHighlight,
    disable: disableHighlight,
    fullyDisable: fullyDisableHighlight,
    isEnabled: function isEnabled() {
      return highlightEnabled;
    },
    getSelectedElement: function getSelectedElement() {
      return selectedElement;
    },
    updateSelected: updateSelectedHighlight,
    // 通过消息发送开关控制
    sendToggleMessage: function sendToggleMessage(enabled) {
      window.parent.postMessage({
        type: 'iframe-highlight-status',
        enabled: enabled || highlightEnabled,
        source: 'iframe-highlight-injector'
      }, '*');
    }
  };

  // 通知父窗口脚本已加载
  try {
    window.parent.postMessage({
      type: "iframe-highlight-ready",
      data: {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: Date.now()
      },
      source: "iframe-highlight-injector"
    }, "*");
  } catch (error) {
    console.warn("无法发送就绪消息到父窗口:", error);
  }

  // 清理函数
  window.__iframeHighlightCleanup = function () {
    fullyDisableHighlight();
    window.removeEventListener("message", handleParentMessage);
    if (overlay.parentElement) {
      overlay.parentElement.removeChild(overlay);
    }
    delete window.__iframeHighlightInitialized;
    delete window.__iframeHighlightCleanup;
  };
})();

</script>

<script>
/**
 * Iframe 元素高亮注入脚本
 * 需要在目标网站中引入此脚本来支持跨域 iframe 高亮功能
 *
 * 使用方法：
 * 1. 将此脚本添加到目标网站的 HTML 中
 * 2. 或通过浏览器扩展、用户脚本等方式注入
 */

(function () {
  "use strict";

  // 检查是否在 iframe 中
  if (window.self === window.top) {
    return; // 不在 iframe 中，不执行
  }

  // 检查是否已经初始化过
  if (window.__iframeHighlightInitialized) {
    return;
  }
  window.__iframeHighlightInitialized = true;
  console.log("Iframe 高亮脚本已加载");

  // 创建高亮覆盖层
  var overlay = document.createElement("div");
  overlay.id = "iframe-highlight-overlay";
  overlay.style.cssText = "\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100vw;\n    height: 100vh;\n    pointer-events: none;\n    z-index: 999999;\n    overflow: hidden;\n  ";

  // 创建悬停高亮框（虚线边框）
  var highlightBox = document.createElement("div");
  highlightBox.id = "iframe-highlight-box";
  highlightBox.style.cssText = "\n    position: absolute;\n    border: 2px dashed #007AFF;\n    background: rgba(0, 122, 255, 0.08);\n    pointer-events: none;\n    display: none;\n    transition: all 0.1s ease;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);\n    border-radius: 2px;\n  ";

  // 创建选中节点的常驻高亮框（实线边框）
  var selectedBox = document.createElement("div");
  selectedBox.id = "iframe-selected-box";
  selectedBox.style.cssText = "\n    position: absolute;\n    border: 2px solid #007AFF;\n    pointer-events: none;\n    display: none;\n    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.9), 0 0 8px rgba(255, 107, 53, 0.4);\n    border-radius: 2px;\n    z-index: 1000000;\n  ";

  // 创建悬停标签显示
  var tagLabel = document.createElement("div");
  tagLabel.id = "iframe-tag-label";
  tagLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 2px 6px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 2px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000001;\n    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);\n    font-weight: 500;\n  ";

  // 创建选中节点标签
  var selectedLabel = document.createElement("div");
  selectedLabel.id = "iframe-selected-label";
  selectedLabel.style.cssText = "\n    position: absolute;\n    background: #007AFF;\n    color: white;\n    padding: 3px 8px;\n    font-size: 11px;\n    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;\n    border-radius: 3px;\n    pointer-events: none;\n    display: none;\n    white-space: nowrap;\n    z-index: 1000002;\n    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);\n    font-weight: 600;\n  ";
  overlay.appendChild(highlightBox);
  overlay.appendChild(selectedBox);
  overlay.appendChild(tagLabel);
  overlay.appendChild(selectedLabel);
  document.body.appendChild(overlay);

  // 存储当前选中的元素
  var selectedElement = null;
  var highlightEnabled = false;

  // 更新选中元素的高亮显示
  function updateSelectedHighlight(element) {
    console.log("updateSelectedHighlight called with:", element);
    if (!element) {
      selectedBox.style.display = "none";
      selectedLabel.style.display = "none";
      selectedElement = null;
      console.log("Cleared selected highlight");
      return;
    }
    selectedElement = element;
    var rect = element.getBoundingClientRect();
    console.log("Selected element rect:", rect);

    // 更新选中高亮框位置
    selectedBox.style.display = "block";
    selectedBox.style.left = "".concat(rect.left - 2, "px");
    selectedBox.style.top = "".concat(rect.top - 2, "px");
    selectedBox.style.width = "".concat(rect.width + 4, "px");
    selectedBox.style.height = "".concat(rect.height + 4, "px");

    // 更新选中标签位置和内容
    selectedLabel.style.display = "block";
    selectedLabel.textContent = "\u2713 <".concat(element.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 28;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 5) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    var labelWidth = selectedLabel.offsetWidth || 100; // 预估宽度
    if (labelLeft + labelWidth > window.innerWidth - 10) {
      labelLeft = window.innerWidth - labelWidth - 10;
    }
    selectedLabel.style.left = "".concat(Math.max(5, labelLeft), "px");
    selectedLabel.style.top = "".concat(labelTop, "px");
    console.log("Selected highlight positioned at:", {
      left: selectedBox.style.left,
      top: selectedBox.style.top,
      width: selectedBox.style.width,
      height: selectedBox.style.height
    });
  }
  function getElementSelector(element) {
    if (!(element instanceof Element)) throw new Error('Argument must be a DOM element');
    var segments = [];
    var current = element;
    while (current !== document.documentElement) {
      var selector = '';
      // 优先检查唯一ID
      if (current.id && document.querySelectorAll("#".concat(current.id)).length === 1) {
        segments.unshift("#".concat(current.id));
        break; // ID唯一，无需继续向上
      }

      // 生成类名选择器（取第一个有效类名）
      var classes = Array.from(current.classList).filter(function (c) {
        return !c.startsWith('js-');
      });
      var className = classes.length > 0 ? ".".concat(classes[0]) : '';

      // 生成位置索引（nth-child）
      var tag = current.tagName.toLowerCase();
      if (!className) {
        var siblings = Array.from(current.parentNode.children);
        var index = siblings.findIndex(function (el) {
          return el === current;
        }) + 1;
        selector = "".concat(tag, ":nth-child(").concat(index, ")");
      } else {
        selector = className;
      }
      segments.unshift(selector);
      current = current.parentElement;
    }

    // 处理根元素
    if (current === document.documentElement) {
      segments.unshift('html');
    }
    return segments.join(' > ');
  }

  // 获取元素文本内容
  function getElementText(element) {
    var _element$textContent;
    if (element.tagName === "INPUT") {
      return element.value || element.placeholder || "";
    }
    if (element.tagName === "TEXTAREA") {
      return element.value || element.placeholder || "";
    }
    var text = ((_element$textContent = element.textContent) === null || _element$textContent === void 0 ? void 0 : _element$textContent.trim()) || "";
    return text.length > 50 ? text.substring(0, 50) + "..." : text;
  }

  // 获取元素属性信息
  function getElementAttributes(element) {
    var attrs = {};
    for (var i = 0; i < element.attributes.length; i++) {
      var attr = element.attributes[i];
      attrs[attr.name] = attr.value;
    }
    return attrs;
  }

  // 鼠标悬停事件处理
  function handleMouseOver(e) {
    if (!highlightEnabled) return;
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免高亮 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 如果是已选中的元素，不显示悬停高亮
    if (target === selectedElement) {
      highlightBox.style.display = "none";
      tagLabel.style.display = "none";
      return;
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);

    // 更新悬停高亮框位置
    highlightBox.style.display = "block";
    highlightBox.style.left = "".concat(rect.left - 2, "px");
    highlightBox.style.top = "".concat(rect.top - 2, "px");
    highlightBox.style.width = "".concat(rect.width + 4, "px");
    highlightBox.style.height = "".concat(rect.height + 4, "px");

    // 更新标签位置和内容
    tagLabel.style.display = "block";
    tagLabel.textContent = "<".concat(target.tagName.toLowerCase(), ">");

    // 计算标签位置，确保不超出视窗
    var labelTop = rect.top - 22;
    var labelLeft = rect.left;

    // 如果标签会超出顶部，显示在元素下方
    if (labelTop < 0) {
      labelTop = rect.bottom + 5;
    }

    // 如果标签会超出右侧，向左调整
    if (labelLeft + tagLabel.offsetWidth > window.innerWidth) {
      labelLeft = window.innerWidth - tagLabel.offsetWidth - 5;
    }
    tagLabel.style.left = "".concat(Math.max(0, labelLeft), "px");
    tagLabel.style.top = "".concat(labelTop, "px");

    // 发送消息到父窗口
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 鼠标离开事件处理
  function handleMouseOut(e) {
    if (!highlightEnabled) return;
    var relatedTarget = e.relatedTarget;

    // 如果鼠标移动到高亮相关元素上，不隐藏高亮
    if (relatedTarget && (relatedTarget === highlightBox || relatedTarget === tagLabel || relatedTarget === overlay || relatedTarget === selectedBox || relatedTarget === selectedLabel)) {
      return;
    }
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    try {
      window.parent.postMessage({
        type: "iframe-element-hover",
        data: null,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 点击事件处理
  function handleClick(e) {
    var target = e.target;
    if (!target || target === overlay || target === highlightBox || target === tagLabel || target === selectedBox || target === selectedLabel) {
      return;
    }

    // 避免处理 html 和 body 元素
    if (target === document.documentElement || target === document.body) {
      return;
    }

    // 检查是否是交互元素，这些元素需要保留默认行为
    var isInteractiveElement = ['input', 'textarea', 'select', 'button', 'a'].includes(target.tagName.toLowerCase());

    // 如果高亮功能启用，对于非交互元素阻止默认行为和事件传播
    if (highlightEnabled) {
      e.preventDefault();
      e.stopPropagation();
    }
    var rect = target.getBoundingClientRect();
    var selector = getElementSelector(target);
    var text = getElementText(target);
    var attributes = getElementAttributes(target);
    console.log("Element clicked:", {
      tagName: target.tagName,
      selector: selector,
      rect: rect
    });

    // 立即更新选中高亮
    updateSelectedHighlight(target);

    // 隐藏悬停高亮，因为现在是选中状态
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    var elementInfo = {
      tagName: target.tagName.toLowerCase(),
      rect: {
        left: rect.left,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height,
        x: rect.x,
        y: rect.y
      },
      selector: selector,
      text: text,
      attributes: attributes,
      url: window.location.href,
      path: window.location.pathname,
      timestamp: Date.now()
    };
    try {
      window.parent.postMessage({
        type: "iframe-element-click",
        data: elementInfo,
        source: "iframe-highlight-injector"
      }, "*");
    } catch (error) {
      console.warn("无法发送消息到父窗口:", error);
    }
  }

  // 监听来自父窗口的消息
  function handleParentMessage(event) {
    console.log("Received message from parent:", event.data);
    if (event.data.type === "iframe-highlight-toggle") {
      var enabled = event.data.enabled;
      console.log("Highlight toggle:", enabled);
      if (enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "enable-iframe-highlight") {
      console.log("Enable iframe highlight");
      enableHighlight();
    } else if (event.data.type === "disable-iframe-highlight") {
      console.log("Disable iframe highlight");
      disableHighlight();
    } else if (event.data.type === "toggle-iframe-highlight") {
      var _enabled = event.data.enabled !== undefined ? event.data.enabled : !highlightEnabled;
      console.log("Toggle iframe highlight to:", _enabled);
      if (_enabled) {
        enableHighlight();
      } else {
        disableHighlight();
      }
    } else if (event.data.type === "update-selected-element") {
      var selector = event.data.selector;
      console.log("Update selected element with selector:", selector);
      if (selector) {
        try {
          var element = document.querySelector(selector);
          console.log("Found element by selector:", element);
          updateSelectedHighlight(element);
        } catch (error) {
          console.warn("Failed to select element:", error);
          updateSelectedHighlight(null);
        }
      } else {
        updateSelectedHighlight(null);
      }
    } else if (event.data.type === "clear-selected-element") {
      console.log("Clear selected element");
      updateSelectedHighlight(null);
    }
  }

  // 启用高亮功能
  function enableHighlight() {
    console.log("Enabling highlight");
    document.addEventListener("mouseover", handleMouseOver, true);
    document.addEventListener("mouseout", handleMouseOut, true);
    document.addEventListener("click", handleClick, true);
    highlightEnabled = true;
    overlay.style.display = "block";
  }

  // 禁用高亮功能
  function disableHighlight() {
    console.log("Disabling highlight");
    highlightEnabled = false;
    // 保持事件监听器，但通过 highlightEnabled 变量控制行为
    // 这样可以保留选中状态的显示
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    // 不隐藏 selectedBox 和 selectedLabel，保留选中状态
  }

  // 完全禁用高亮功能（移除所有监听器）
  function fullyDisableHighlight() {
    console.log("Fully disabling highlight");
    highlightEnabled = false;
    document.removeEventListener("mouseover", handleMouseOver, true);
    document.removeEventListener("mouseout", handleMouseOut, true);
    document.removeEventListener("click", handleClick, true);
    overlay.style.display = "none";
    highlightBox.style.display = "none";
    tagLabel.style.display = "none";
    selectedBox.style.display = "none";
    selectedLabel.style.display = "none";
  }

  // 添加事件监听
  enableHighlight();
  window.addEventListener("message", handleParentMessage);

  // 暴露全局函数供外部调用
  window.__iframeHighlightControl = {
    enable: enableHighlight,
    disable: disableHighlight,
    fullyDisable: fullyDisableHighlight,
    isEnabled: function isEnabled() {
      return highlightEnabled;
    },
    getSelectedElement: function getSelectedElement() {
      return selectedElement;
    },
    updateSelected: updateSelectedHighlight,
    // 通过消息发送开关控制
    sendToggleMessage: function sendToggleMessage(enabled) {
      window.parent.postMessage({
        type: 'iframe-highlight-status',
        enabled: enabled || highlightEnabled,
        source: 'iframe-highlight-injector'
      }, '*');
    }
  };

  // 通知父窗口脚本已加载
  try {
    window.parent.postMessage({
      type: "iframe-highlight-ready",
      data: {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: Date.now()
      },
      source: "iframe-highlight-injector"
    }, "*");
  } catch (error) {
    console.warn("无法发送就绪消息到父窗口:", error);
  }

  // 清理函数
  window.__iframeHighlightCleanup = function () {
    fullyDisableHighlight();
    window.removeEventListener("message", handleParentMessage);
    if (overlay.parentElement) {
      overlay.parentElement.removeChild(overlay);
    }
    delete window.__iframeHighlightInitialized;
    delete window.__iframeHighlightCleanup;
  };
})();

</script>
</body>
</html>
