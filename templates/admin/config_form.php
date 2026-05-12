<?php if(!empty($msg)):?><div class="msg ok">✓ <?=$msg?></div><?php endif;?>
<form method="post" id="configForm">
<input type="hidden" name="current_tab" id="currentTab" value="<?=h($tab)?>">
<div class="tabs">
    <button type="button" class="<?=$tab==='basic'?'on':''?>" data-tab="basic" onclick="switchTab('basic')">基本信息</button>
    <button type="button" class="<?=$tab==='theme'?'on':''?>" data-tab="theme" onclick="switchTab('theme')">🎨 主题</button>
    <button type="button" class="<?=$tab==='hero'?'on':''?>" data-tab="hero" onclick="switchTab('hero')">📊 指标</button>
    <button type="button" class="<?=$tab==='social'?'on':''?>" data-tab="social" onclick="switchTab('social')">🔗 社交</button>
    <button type="button" class="<?=$tab==='skills'?'on':''?>" data-tab="skills" onclick="switchTab('skills')">💡 技能</button>
    <button type="button" class="<?=$tab==='projects'?'on':''?>" data-tab="projects" onclick="switchTab('projects')">🔮 项目</button>
    <button type="button" class="<?=$tab==='travel'?'on':''?>" data-tab="travel" onclick="switchTab('travel')">✈ 旅行</button>
    <button type="button" class="<?=$tab==='invest'?'on':''?>" data-tab="invest" onclick="switchTab('invest')">📈 投资</button>
    <button type="button" class="<?=$tab==='media'?'on':''?>" data-tab="media" onclick="switchTab('media')">📖 书影音</button>
    <button type="button" class="<?=$tab==='blocks'?'on':''?>" data-tab="blocks" onclick="switchTab('blocks')">🧩 板块</button>
    <button type="button" class="<?=$tab==='system'?'on':''?>" data-tab="system" onclick="switchTab('system')">⚙️ 系统</button>
    <button type="button" class="<?=$tab==='ext'?'on':''?>" data-tab="ext" onclick="switchTab('ext')">🔧 扩展</button>
</div>

<!-- 基本信息 -->
<div id="basic" class="section <?=$tab==='basic'?'show':''?>">
<div class="card">
    <h3>👤 基本信息配置</h3>
    <div class="row">
        <div class="field"><label>姓名</label><input name="name" value="<?=h($B['name']??'')?>"></div>
        <div class="field"><label>职位/头衔</label><input name="job_title" value="<?=h($B['job_title']??'')?>"></div>
        <div class="field"><label>头像URL</label><input name="avatar_url" value="<?=h($B['avatar_url']??'')?>" placeholder="留空显示姓名首字"></div>
    </div>
    <div class="row">
        <div class="field"><label>状态标签 <small style="color:var(--muted)">头像旁边，逗号分隔</small></label><input name="status_tags" value="<?=h(implode(', ',$B['status_tags']??[]))?>" placeholder="📍上海, ✈旅行中"></div>
        <div class="field"><label>技能标签 <small style="color:var(--muted)">关于我卡片，逗号分隔</small></label><input name="hero_tags" value="<?=h(implode(', ',$B['hero_tags']??[]))?>" placeholder="产品设计, Python, Swift"></div>
    </div>
    <div class="field"><label>一句话简介</label><textarea name="bio_summary" rows="3"><?=h($B['bio_summary']??'')?></textarea></div>
    <div class="field"><label>此刻·Now</label><textarea name="now_text" rows="2"><?=h($B['now_text']??'')?></textarea></div>
    <div class="field"><label>座右铭</label><input name="motto" value="<?=h($B['motto']??'')?>"></div>
    <div class="field"><label>位置/城市</label><input name="location" value="<?=h($B['location']??'')?>" placeholder="上海，中国"></div>
    <div class="field"><label>照片墙 <small style="color:var(--muted)">每行一个URL</small></label><textarea name="photo_wall" rows="3" placeholder="https://..."><?=h(implode("\n",$B['photo_wall']??[]))?></textarea></div>
    <div class="row">
        <div class="field"><label>展示视频URL</label><input name="video_url" value="<?=h($B['video_url']??'')?>" placeholder="mp4/B站嵌入"></div>
        <div class="field"><label>封面图URL</label><input name="cover_image" value="<?=h($B['cover_image']??'')?>" placeholder="留空使用默认"></div>
    </div>
    <div class="row">
        <div class="field"><label>备案号</label><input name="icp_info" value="<?=h($CTX['icp']??'')?>"></div>
        <div class="field"><label>底部版权</label><input name="footer_copyright" value="<?=h($CTX['copyright']??'')?>"></div>
    </div>
</div>
</div>

<!-- 主题 -->
<div id="theme" class="section <?=$tab==='theme'?'show':''?>">
<div class="card">
    <h3>🎨 主题切换</h3>
    <div class="field"><label>当前主题</label>
        <select name="active_theme" id="activeTheme" onchange="updateThemeDesc()">
        <?php foreach($available_themes as $t):?>
            <option value="<?=h($t['folder'])?>" <?=$active_theme===$t['folder']?'selected':''?>><?=h($t['name'])?></option>
        <?php endforeach;?>
        </select>
    </div>
    <div id="themeInfo" style="background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:14px">
        <div style="font-size:13px;margin-bottom:8px"><strong id="themeName"><?=h($active_theme_data['name']??'')?></strong> <span style="color:var(--text3)">v<?=h($active_theme_data['version']??'1.0')?></span></div>
        <div style="font-size:12px;color:var(--text3)"><?=h($active_theme_data['description']??'')?></div>
    </div>
    <div class="field"><label>文章目录名</label><input name="posts_slug" value="<?=h($SYS['posts_slug']??'posts')?>"></div>
</div>
</div>

<!-- 指标 -->
<div id="hero" class="section <?=$tab==='hero'?'show':''?>">
<div class="card">
    <h3>📊 核心指标（KV自定义）</h3>
    <div id="hero-stats-list">
    <?php foreach($CTX['hero_stats']??[] as $k=>$v):?>
        <div style="display:grid;grid-template-columns:160px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="hero_key[]" value="<?=h($k)?>" placeholder="cities">
            <input name="hero_val[]" value="<?=h($v)?>" placeholder="47">
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addKVRow('hero-stats-list','hero')">➕ 添加</button>
</div>
</div>

<!-- 社交 -->
<div id="social" class="section <?=$tab==='social'?'show':''?>">
<div class="card">
    <h3>🔗 社交与联系方式</h3>
    <div id="social-list">
    <?php foreach($S as $k=>$v):?>
        <div style="display:grid;grid-template-columns:160px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="social_key[]" value="<?=h($k)?>" placeholder="email / github">
            <input name="social_val[]" value="<?=h($v)?>" placeholder="链接或内容">
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addKVRow('social-list','social')">➕ 添加</button>
    <div class="hint" style="margin-top:12px">常用key: email, github, weibo, bilibili, twitter, telegram, phone, wechat_qrcode, alipay_qrcode</div>
</div>
</div>

<!-- 技能 -->
<div id="skills" class="section <?=$tab==='skills'?'show':''?>">
<div class="card">
    <h3>💡 技能列表</h3>
    <div id="skills-list">
    <?php foreach($L['skills']??[] as $k=>$v):?>
        <div style="display:grid;grid-template-columns:200px 100px 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="skill_name[]" value="<?=h($k)?>" placeholder="技能名">
            <input name="skill_pct[]" type="number" value="<?=h($v)?>" min="0" max="100">
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addSkillRow()">➕ 添加</button>
</div>
</div>

<!-- 项目 -->
<div id="projects" class="section <?=$tab==='projects'?'show':''?>">
<div class="card">
    <h3>🔮 项目展示</h3>
    <div id="project-list">
    <?php $pi=0; foreach($L['projects']??[] as $p):?>
        <div class="project-block" style="background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:12px">
            <div style="display:grid;grid-template-columns:2fr 3fr 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
                <input name="proj_name[]" value="<?=h($p['name']??'')?>" placeholder="项目名称">
                <input name="proj_desc[]" value="<?=h($p['desc']??'')?>" placeholder="描述">
                <input name="proj_url[]" value="<?=h($p['url']??'')?>" placeholder="链接">
                <button type="button" class="btn" onclick="this.parentElement.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
            </div>
            <div class="tags-container" style="display:flex;gap:6px;flex-wrap:wrap">
                <?php if(!empty($p['tags'])): $ti=0; foreach($p['tags'] as $tag):?>
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;background:rgba(255,255,255,0.06);font-size:12px">
                        <select name="proj_tag_colors[<?=$pi?>][<?=$ti?>]" style="padding:2px;border-radius:4px;background:transparent;color:var(--text);font-size:11px">
                            <option value="g" <?=($tag['color']??'')==='g'?'selected':''?>>🟢</option>
                            <option value="b" <?=($tag['color']??'')==='b'?'selected':''?>>🔵</option>
                            <option value="a" <?=($tag['color']??'')==='a'?'selected':''?>>🟠</option>
                        </select>
                        <input name="proj_tags[<?=$pi?>][<?=$ti?>]" value="<?=h($tag['text']??'')?>" style="width:80px;padding:2px 4px;border-radius:4px;background:transparent;color:var(--text);font-size:11px">
                        <button type="button" onclick="this.parentElement.remove()" style="border:0;background:transparent;color:#f87171;cursor:pointer;font-size:11px">✕</button>
                    </span>
                <?php $ti++; endforeach; endif;?>
            </div>
            <button type="button" class="btn" onclick="addProjTag(this, <?=$pi?>)" style="margin-top:8px;padding:2px 8px;font-size:11px">+标签</button>
        </div>
    <?php $pi++; endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addProjectRow()">➕ 添加项目</button>
</div>
</div>

<!-- 旅行 -->
<div id="travel" class="section <?=$tab==='travel'?'show':''?>">
<div class="card">
    <h3>✈️ 旅行足迹</h3>
    <div id="travel-list">
    <?php foreach($L['travel']??[] as $t):?>
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="travel_place[]" value="<?=h($t['place']??'')?>" placeholder="🇯🇵 京都">
            <input name="travel_date[]" value="<?=h($t['date']??'')?>" placeholder="2025年3月">
            <select name="travel_status[]">
                <option value="done" <?=($t['status']??'')==='done'?'selected':''?>>已完成</option>
                <option value="plan" <?=($t['status']??'')==='plan'?'selected':''?>>计划中</option>
            </select>
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addTravelRow()">➕ 添加</button>
</div>
</div>

<!-- 投资 -->
<div id="invest" class="section <?=$tab==='invest'?'show':''?>">
<div class="card">
    <h3>📈 投资记录</h3>
    <div class="row" style="margin-bottom:16px">
        <div class="field"><label>今年收益率</label><input name="inv_returns" value="<?=h($H['investment']['returns']??'')?>"></div>
        <div class="field"><label>总资产规模</label><input name="inv_total" value="<?=h($H['investment']['total']??'')?>"></div>
    </div>
    <h4 style="margin:20px 0 12px;font-size:14px">资产配置</h4>
    <div id="alloc-list">
    <?php if(!empty($H['investment']['allocations'])):foreach($H['investment']['allocations'] as $a):?>
        <div style="display:grid;grid-template-columns:2fr 100px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="alloc_name[]" value="<?=h($a['name']??'')?>">
            <input name="alloc_pct[]" type="number" value="<?=h($a['pct']??'')?>" min="0" max="100">
            <select name="alloc_color[]">
                <option value="var(--bar1)" <?=($a['color']??'')==='var(--bar1)'?'selected':''?>>色系1</option>
                <option value="var(--bar2)" <?=($a['color']??'')==='var(--bar2)'?'selected':''?>>色系2</option>
                <option value="var(--bar3)" <?=($a['color']??'')==='var(--bar3)'?'selected':''?>>色系3</option>
                <option value="var(--bar4)" <?=($a['color']??'')==='var(--bar4)'?'selected':''?>>色系4</option>
            </select>
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;endif;?>
    </div>
    <button type="button" class="btn" onclick="addAllocRow()">➕ 添加</button>
</div>
</div>

<!-- 书影音 -->
<div id="media" class="section <?=$tab==='media'?'show':''?>">
<div class="card">
    <h3>📖 书影音</h3>
    <div id="media-list">
    <?php foreach($H['media']??[] as $m):?>
        <div style="display:grid;grid-template-columns:60px 2fr 2fr 80px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center">
            <input name="media_icon[]" value="<?=h($m['icon']??'')?>" style="text-align:center;font-size:18px">
            <input name="media_title[]" value="<?=h($m['title']??'')?>" placeholder="名称">
            <input name="media_sub[]" value="<?=h($m['sub']??'')?>" placeholder="副标题">
            <input name="media_progress[]" type="number" value="<?=h($m['progress']??0)?>" min="0" max="100" placeholder="%">
            <select name="media_bg[]">
                <option value="var(--amber-dim)" <?=($m['bg']??'')==='var(--amber-dim)'?'selected':''?>>橙色</option>
                <option value="var(--blue-dim)" <?=($m['bg']??'')==='var(--blue-dim)'?'selected':''?>>蓝色</option>
                <option value="var(--green-dim)" <?=($m['bg']??'')==='var(--green-dim)'?'selected':''?>>绿色</option>
            </select>
            <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
        </div>
    <?php endforeach;?>
    </div>
    <button type="button" class="btn" onclick="addMediaRow()">➕ 添加</button>
</div>
</div>

<!-- 板块可见性 -->
<div id="blocks" class="section <?=$tab==='blocks'?'show':''?>">
<div class="card">
    <h3>🧩 板块可见性控制</h3>
    <p style="font-size:12px;color:var(--text3);margin-bottom:16px">控制主页Bento卡片的显示与隐藏</p>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
    <?php
    $defaultBlocks = ['about'=>'关于我','now'=>'此刻·Now','activity'=>'日常动态','travel'=>'旅行足迹','projects'=>'项目展示','invest'=>'投资记录','media'=>'书影音','contact'=>'联系方式'];
    foreach($defaultBlocks as $key=>$label):?>
        <label style="display:flex;align-items:center;gap:8px;padding:10px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid var(--border);cursor:pointer;font-size:13px">
            <input type="checkbox" name="blocks[<?=$key?>]" value="1" <?=!isset($BLK[$key])||$BLK[$key]?'checked':''?>>
            <?=$label?>
        </label>
    <?php endforeach;?>
    </div>
</div>
</div>

<!-- 系统设置 -->
<div id="system" class="section <?=$tab==='system'?'show':''?>">
<div class="card">
    <h3>⚙️ 系统设置</h3>
    <h4 style="margin-bottom:12px;font-size:14px">SEO</h4>
    <div class="field"><label>网站标题</label><input name="seo[title]" value="<?=h($SEO['title']??'')?>"></div>
    <div class="field"><label>关键词</label><input name="seo[keywords]" value="<?=h($SEO['keywords']??'')?>"></div>
    <div class="field"><label>描述</label><textarea name="seo[description]" rows="2"><?=h($SEO['description']??'')?></textarea></div>

    <h4 style="margin:20px 0 12px;font-size:14px">🖼 Favicon 图标</h4>
    <p style="color:var(--muted);font-size:13px;margin-bottom:12px">浏览器标签页显示的小图标，可上传或用文字生成</p>
    <?php $faviconUrl = $SEO['favicon'] ?? ''; ?>
    <div style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap">
        <!-- 当前favicon -->
        <div style="text-align:center">
            <div style="width:64px;height:64px;border:2px dashed var(--border);border-radius:12px;display:flex;align-items:center;justify-content:center;overflow:hidden;background:rgba(255,255,255,0.03)" id="faviconPreview">
                <?php if($faviconUrl): ?>
                    <img src="<?=h($faviconUrl)?>" style="width:48px;height:48px;image-rendering:pixelated" id="faviconImg">
                <?php else: ?>
                    <span style="color:var(--muted);font-size:11px">暂无</span>
                <?php endif; ?>
            </div>
            <div style="font-size:11px;color:var(--muted);margin-top:6px">当前图标</div>
        </div>
        <!-- 上传区域 -->
        <div style="flex:1;min-width:200px">
            <div style="margin-bottom:10px">
                <label style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:var(--accent);color:#fff;cursor:pointer;font-size:13px;font-weight:500">
                    📤 上传图标
                    <input type="file" id="faviconUpload" accept="image/*,.ico,.svg" style="display:none">
                </label>
                <span style="font-size:11px;color:var(--muted);margin-left:8px">PNG/JPG/ICO/SVG</span>
            </div>
            <div id="uploadMsg" style="font-size:12px;color:var(--muted)"></div>
        </div>
    </div>

    <!-- 文字生成 -->
    <div style="margin-top:16px;padding:14px;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid var(--border)">
        <div style="font-size:13px;font-weight:500;margin-bottom:10px">✨ 文字生成图标</div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <input type="text" id="favText" value="峰" placeholder="输入1-2个字" maxlength="2" style="width:70px;padding:6px 10px;border-radius:8px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:14px;text-align:center">
            <div style="display:flex;align-items:center;gap:6px">
                <label style="font-size:12px;color:var(--text3)">背景</label>
                <input type="color" id="favBgColor" value="#3B82F6" style="width:32px;height:32px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:1px;background:transparent">
                <input type="text" id="favBgHex" value="#3B82F6" maxlength="7" style="width:80px;padding:4px 6px;border-radius:6px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:12px;font-family:monospace">
            </div>
            <div style="display:flex;align-items:center;gap:6px">
                <label style="font-size:12px;color:var(--text3)">文字</label>
                <input type="color" id="favTextColor" value="#FFFFFF" style="width:32px;height:32px;border:1px solid var(--border);border-radius:6px;cursor:pointer;padding:1px;background:transparent">
                <input type="text" id="favTextHex" value="#FFFFFF" maxlength="7" style="width:80px;padding:4px 6px;border-radius:6px;border:1px solid var(--border);background:transparent;color:var(--text);font-size:12px;font-family:monospace">
            </div>
            <button type="button" class="btn primary" onclick="generateFavicon()" style="padding:6px 14px;font-size:13px">生成并使用</button>
        </div>
        <div id="favGenPreview" style="margin-top:12px;display:flex;align-items:center;gap:12px">
            <div id="favPreviewBox" style="width:64px;height:64px;border-radius:12px;overflow:hidden;background:#3B82F6;display:flex;align-items:center;justify-content:center">
                <span style="color:#fff;font-size:24px;font-weight:700;line-height:1">峰</span>
            </div>
            <div>
                <div style="font-size:11px;color:var(--muted)">实时预览</div>
                <div style="font-size:10px;color:var(--muted);margin-top:2px">修改颜色后自动更新</div>
            </div>
        </div>
        <div style="margin-top:10px">
            <label style="font-size:11px;color:var(--muted);cursor:pointer">预设配色：</label>
            <span id="presetColors" style="display:inline-flex;gap:4px;margin-left:4px;flex-wrap:wrap"></span>
        </div>
    </div>
    <input type="hidden" name="seo[favicon]" id="faviconUrl" value="<?=h($faviconUrl)?>">
    <h4 style="margin:24px 0 12px;font-size:14px">🎵 背景音乐</h4>
    <label style="display:flex;align-items:center;gap:8px;margin-bottom:8px;font-size:13px"><input type="checkbox" name="music_enabled" value="1" <?=!empty($SYS['music']['enabled'])?'checked':''?>> 启用背景音乐</label>
    <div class="field"><label>播放列表（每行一首：标题|URL）</label>
    <textarea name="music_playlist" rows="5" style="width:100%;border-radius:8px;border:1px solid var(--glass-border);padding:8px;font-size:13px" placeholder="歌名1|https://xxx.mp3&#10;歌名2|https://yyy.mp3"><?=h(@implode("\n", array_map(fn($p)=>($p['title']??'').'|'.($p['url']??''), $SYS['music']['playlist']??[])))?></textarea></div>
    <label style="display:flex;align-items:center;gap:8px;margin-bottom:16px;font-size:13px"><input type="checkbox" name="music_autoplay" value="1" <?=!empty($SYS['music']['autoplay'])?'checked':''?>> 自动播放</label>
    <h4 style="margin:24px 0 12px;font-size:14px">🛠 代码注入</h4>
    <div class="field"><label>Header代码 <small style="color:var(--muted)">统计代码、自定义CSS等</small></label><textarea name="custom_header" rows="4"><?=h($SYS['custom_header']??'')?></textarea></div>
    <div class="field"><label>Footer代码 <small style="color:var(--muted)">3D看板娘、自定义JS等</small></label><textarea name="custom_footer" rows="4"><?=h($SYS['custom_footer']??'')?></textarea></div>
    <h4 style="margin-top:20px;color:var(--accent)">🌤 天气显示配置</h4>
    <p style="color:var(--muted);font-size:13px;margin-bottom:12px">使用 wttr.in 免费接口，无需API Key</p>
    <div class="row">
        <div class="field"><label>天气城市</label><input name="weather_city" value="<?=h($SYS['weather']['city'] ?? 'Shanghai')?>" placeholder="Shanghai / Beijing"></div>
        <label style="display:flex;align-items:center;gap:8px;margin-top:24px"><input type="checkbox" name="weather_enabled" value="1" <?=!empty($SYS['weather']['enabled'])?'checked':''?>> 启用天气显示</label>
    </div>
    <h4 style="margin:24px 0 12px;font-size:14px">📦 万能扩展 (ext_json)</h4>
    <div class="field"><textarea name="extra_raw" rows="6"><?=h(json_encode($EXT, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))?></textarea><div class="hint">JSON格式，存储未来新模板可能需要的任何参数</div></div>
</div>
</div>

<!-- 扩展设置 (KV) -->
<div id="ext" class="section <?=$tab==='ext'?'show':''?>">
<div class="card">
    <h3>🔧 扩展设置 (Key-Value)</h3>
    <p style="color:var(--muted);margin-bottom:16px;font-size:13px">模板特有的配置项，如副标题、自定义文案等。模板调用：<code>$CTX['system']['ext']['key']</code></p>
    <div id="ext-list">
    <?php $ext = $SYS['ext'] ?? []; $i=0; foreach($ext as $k=>$v): ?>
    <div style="display:grid;grid-template-columns:1fr 2fr 40px;gap:8px;margin-bottom:8px;align-items:center">
        <input name="ext_key[]" value="<?=h($k)?>" placeholder="键名">
        <input name="ext_val[]" value="<?=h($v)?>" placeholder="值">
        <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
    </div>
    <?php $i++; endforeach; if($i===0): ?>
    <div style="display:grid;grid-template-columns:1fr 2fr 40px;gap:8px;margin-bottom:8px;align-items:center">
        <input name="ext_key[]" placeholder="键名">
        <input name="ext_val[]" placeholder="值">
        <button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>
    </div>
    <?php endif;?>
    </div>
    <button type="button" class="btn" onclick="addExtRow()" style="margin-top:8px">+ 添加一项</button>
</div>
</div>

<div style="margin-top:24px">
    <button class="btn primary" type="submit">💾 保存配置</button>
    <a class="btn" href="generate.php">🚀 保存并生成</a>
</div>
</form>

<script>
var projectCount=<?=count($L['projects']??[])?>;

function switchTab(id){
  document.getElementById('currentTab').value=id;
  document.querySelectorAll('.section').forEach(s=>s.classList.remove('show'));
  document.querySelectorAll('.tabs button').forEach(b=>b.classList.remove('on'));
  document.getElementById(id).classList.add('show');
  document.querySelector('[data-tab="'+id+'"]').classList.add('on');
}

function addKVRow(cid,t){
  var c=document.getElementById(cid);
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:160px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="'+t+'_key[]" placeholder="Key"><input name="'+t+'_val[]" placeholder="Value"><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function addSkillRow(){
  var c=document.getElementById('skills-list');
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:200px 100px 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="skill_name[]" placeholder="技能"><input name="skill_pct[]" type="number" min="0" max="100"><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function addTravelRow(){
  var c=document.getElementById('travel-list');
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:2fr 1fr 1fr 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="travel_place[]" placeholder="🇯🇵 京都"><input name="travel_date[]" placeholder="2025年3月"><select name="travel_status[]"><option value="done">已完成</option><option value="plan">计划中</option></select><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function addProjectRow(){
  var c=document.getElementById('project-list');
  var idx=projectCount++;
  var b=document.createElement('div');
  b.className='project-block';
  b.style.cssText='background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:12px';
  b.innerHTML='<div style="display:grid;grid-template-columns:2fr 3fr 1fr 40px;gap:8px;margin-bottom:8px;align-items:center"><input name="proj_name[]" placeholder="项目名"><input name="proj_desc[]" placeholder="描述"><input name="proj_url[]" placeholder="链接"><button type="button" class="btn" onclick="this.parentElement.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button></div><div class="tags-container" style="display:flex;gap:6px;flex-wrap:wrap"></div><button type="button" class="btn" onclick="addProjTag(this,'+idx+')" style="margin-top:8px;padding:2px 8px;font-size:11px">+标签</button>';
  c.appendChild(b);
}

function addProjTag(btn,idx){
  var c=btn.previousElementSibling;
  var n=c.children.length;
  var s=document.createElement('span');
  s.style.cssText='display:inline-flex;align-items:center;gap:4px;padding:4px 8px;border-radius:6px;background:rgba(255,255,255,0.06);font-size:12px';
  s.innerHTML='<select name="proj_tag_colors['+idx+']['+n+']" style="padding:2px;border-radius:4px;background:transparent;color:var(--text);font-size:11px"><option value="g">🟢</option><option value="b">🔵</option><option value="a">🟠</option></select><input name="proj_tags['+idx+']['+n+']" style="width:80px;padding:2px 4px;border-radius:4px;background:transparent;color:var(--text);font-size:11px"><button type="button" onclick="this.parentElement.remove()" style="border:0;background:transparent;color:#f87171;cursor:pointer;font-size:11px">✕</button>';
  c.appendChild(s);
}

function addAllocRow(){
  var c=document.getElementById('alloc-list');
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:2fr 100px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="alloc_name[]" placeholder="类别"><input name="alloc_pct[]" type="number" min="0" max="100"><select name="alloc_color[]"><option value="var(--bar1)">色系1</option><option value="var(--bar2)">色系2</option><option value="var(--bar3)">色系3</option><option value="var(--bar4)">色系4</option></select><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function addExtRow(){
  var c=document.getElementById('ext-list');
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:1fr 2fr 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="ext_key[]" placeholder="键名"><input name="ext_val[]" placeholder="值"><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function addMediaRow(){
  var c=document.getElementById('media-list');
  var r=document.createElement('div');
  r.style.cssText='display:grid;grid-template-columns:60px 2fr 2fr 80px 1fr 40px;gap:8px;margin-bottom:8px;align-items:center';
  r.innerHTML='<input name="media_icon[]" style="text-align:center;font-size:18px" placeholder="📗"><input name="media_title[]" placeholder="名称"><input name="media_sub[]" placeholder="副标题"><input name="media_progress[]" type="number" min="0" max="100" placeholder="%"><select name="media_bg[]"><option value="var(--amber-dim)">橙色</option><option value="var(--blue-dim)">蓝色</option><option value="var(--green-dim)">绿色</option></select><button type="button" class="btn" onclick="this.parentElement.remove()" style="padding:6px 10px;color:#f87171">✕</button>';
  c.appendChild(r);
}

function updateThemeDesc(){
  var sel=document.getElementById('activeTheme');
  var themes=<?=json_encode($available_themes)?>;
  var t=themes.find(t=>t.folder===sel.value);
  if(t){document.getElementById('themeName').textContent=t.name||t.folder;}
}

// 初始化tab
switchTab('<?=$tab?>');

// === Favicon功能 ===
// 预设配色
var faviconPresets = [
  {bg:'#3B82F6',text:'#FFFFFF',name:'蓝'},
  {bg:'#8B5CF6',text:'#FFFFFF',name:'紫'},
  {bg:'#10B981',text:'#FFFFFF',name:'绿'},
  {bg:'#F97316',text:'#FFFFFF',name:'橙'},
  {bg:'#EF4444',text:'#FFFFFF',name:'红'},
  {bg:'#06B6D4',text:'#FFFFFF',name:'青'},
  {bg:'#EC4899',text:'#FFFFFF',name:'粉'},
  {bg:'#1E1E1E',text:'#FFFFFF',name:'深'},
  {bg:'#FFFFFF',text:'#3B82F6',name:'反'},
  {bg:'#FEF3C7',text:'#B45309',name:'金'},
];

// 生成预设按钮
(function(){
  var html='';
  faviconPresets.forEach(function(p,i){
    html+='<button type="button" onclick="applyPreset('+i+')" style="width:22px;height:22px;border-radius:6px;border:1px solid var(--border);cursor:pointer;background:'+p.bg+';position:relative" title="'+p.name+'"><span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:10px;font-weight:700;color:'+p.text+'">峰</span></button>';
  });
  document.getElementById('presetColors').innerHTML=html;
})();

function applyPreset(idx){
  var p=faviconPresets[idx];
  document.getElementById('favBgColor').value=p.bg;
  document.getElementById('favBgHex').value=p.bg;
  document.getElementById('favTextColor').value=p.text;
  document.getElementById('favTextHex').value=p.text;
  updateFaviconPreview();
}

// 颜色选择器和hex输入框双向同步
document.getElementById('favBgColor').addEventListener('input',function(e){
  document.getElementById('favBgHex').value=e.target.value.toUpperCase();
  updateFaviconPreview();
});
document.getElementById('favBgHex').addEventListener('input',function(e){
  var v=e.target.value;
  if(/^#[0-9a-fA-F]{6}$/.test(v)){
    document.getElementById('favBgColor').value=v;
    updateFaviconPreview();
  }
});
document.getElementById('favTextColor').addEventListener('input',function(e){
  document.getElementById('favTextHex').value=e.target.value.toUpperCase();
  updateFaviconPreview();
});
document.getElementById('favTextHex').addEventListener('input',function(e){
  var v=e.target.value;
  if(/^#[0-9a-fA-F]{6}$/.test(v)){
    document.getElementById('favTextColor').value=v;
    updateFaviconPreview();
  }
});
document.getElementById('favText').addEventListener('input',updateFaviconPreview);

// 实时预览（本地）
function updateFaviconPreview(){
  var text=document.getElementById('favText').value||'峰';
  var bg=document.getElementById('favBgColor').value;
  var fg=document.getElementById('favTextColor').value;
  var box=document.getElementById('favPreviewBox');
  box.style.background=bg;
  box.innerHTML='<span style="color:'+fg+';font-size:24px;font-weight:700;line-height:1">'+text.substr(0,2)+'</span>';
}

// 上传favicon
document.getElementById('faviconUpload').addEventListener('change', function(e){
  var file = e.target.files[0];
  if(!file) return;
  var fd = new FormData();
  fd.append('favicon', file);
  fetch('favicon.php?action=upload', {method:'POST', body:fd})
    .then(r=>r.json())
    .then(d=>{
      if(d.ok){
        document.getElementById('faviconUrl').value = d.url;
        document.getElementById('faviconPreview').innerHTML = '<img src="'+d.url+'?t='+Date.now()+'" style="width:48px;height:48px;image-rendering:pixelated;border-radius:8px" id="faviconImg">';
        document.getElementById('uploadMsg').textContent = '✓ ' + d.msg;
        document.getElementById('uploadMsg').style.color = 'var(--green)';
      } else {
        document.getElementById('uploadMsg').textContent = '✗ ' + d.msg;
        document.getElementById('uploadMsg').style.color = '#f87171';
      }
    });
});

// 生成并使用favicon
function generateFavicon(){
  var text = document.getElementById('favText').value.trim();
  if(!text){ alert('请输入文字'); return; }
  var bgColor = document.getElementById('favBgHex').value;
  var textColor = document.getElementById('favTextHex').value;
  var fd = new FormData();
  fd.append('text', text);
  fd.append('bgColor', bgColor);
  fd.append('textColor', textColor);
  fetch('favicon.php?action=generate', {method:'POST', body:fd})
    .then(r=>r.json())
    .then(d=>{
      if(d.ok){
        document.getElementById('faviconUrl').value = d.url;
        document.getElementById('faviconPreview').innerHTML = '<img src="'+d.url+'?t='+Date.now()+'" style="width:48px;height:48px;image-rendering:pixelated;border-radius:8px" id="faviconImg">';
        document.getElementById('uploadMsg').textContent = '✓ ' + d.msg;
        document.getElementById('uploadMsg').style.color = 'var(--green)';
      } else {
        document.getElementById('uploadMsg').textContent = '✗ ' + d.msg;
        document.getElementById('uploadMsg').style.color = '#f87171';
      }
    });
}

// 初始化预览
updateFaviconPreview();
</script>
