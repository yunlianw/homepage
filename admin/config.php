<?php
/**
 * 资料配置控制器 - 全能适配协议
 * 6个JSON字段：basic_json, hero_stats_json, social_json, list_data_json, hobby_json, system_json
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/VERSION.php';

session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$pdo = getDB();
$msg = '';

// 扫描主题
function scanThemes(): array {
    $themes = [];
    $dirs = glob(THEME_DIR . '/*', GLOB_ONLYDIR);
    foreach ($dirs as $dir) {
        $folder = basename($dir);
        $jsonPath = $dir . '/theme.json';
        $meta = ['folder' => $folder, 'name' => $folder, 'version' => '1.0', 'author' => '', 'description' => ''];
        if (file_exists($jsonPath)) {
            $j = json_decode(file_get_contents($jsonPath), true);
            if ($j) $meta = array_merge($meta, $j);
        }
        $themes[] = $meta;
    }
    return $themes;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tab = $_POST['current_tab'] ?? 'basic';

    // === basic_json ===
    $basic = [
        'name' => $_POST['name'] ?? '',
        'job_title' => $_POST['job_title'] ?? '',
        'bio_summary' => $_POST['bio_summary'] ?? '',
        'avatar_url' => $_POST['avatar_url'] ?? '',
        'photo_wall' => array_filter(explode("\n", trim($_POST['photo_wall'] ?? ''))),
        'video_url' => $_POST['video_url'] ?? '',
        'cover_image' => $_POST['cover_image'] ?? '',
        'motto' => $_POST['motto'] ?? '',
        'location' => $_POST['location'] ?? '',
        'hero_tags' => array_map('trim', explode(',', $_POST['hero_tags'] ?? '')),
        'status_tags' => array_map('trim', explode(',', $_POST['status_tags'] ?? '')),
        'now_text' => $_POST['now_text'] ?? '',
    ];

    // === hero_stats_json ===
    $hero_stats = [];
    if (!empty($_POST['hero_key'])) {
        foreach ($_POST['hero_key'] as $i => $key) {
            $key = trim($key);
            $val = trim($_POST['hero_val'][$i] ?? '');
            if ($key && $val !== '') $hero_stats[$key] = $val;
        }
    }

    // === social_json ===
    $social = [];
    if (!empty($_POST['social_key'])) {
        foreach ($_POST['social_key'] as $i => $key) {
            $key = trim($key);
            $val = trim($_POST['social_val'][$i] ?? '');
            if ($key && $val) $social[$key] = $val;
        }
    }

    // === list_data_json ===
    $skills = [];
    if (!empty($_POST['skill_name'])) {
        foreach ($_POST['skill_name'] as $i => $name) {
            $name = trim($name);
            $pct = intval($_POST['skill_pct'][$i] ?? 0);
            if ($name) $skills[$name] = $pct;
        }
    }

    $projects = [];
    if (!empty($_POST['proj_name'])) {
        foreach ($_POST['proj_name'] as $i => $name) {
            $name = trim($name);
            if (!$name) continue;
            $tags = [];
            $tagTexts = $_POST['proj_tags'][$i] ?? [];
            $tagColors = $_POST['proj_tag_colors'][$i] ?? [];
            foreach ($tagTexts as $j => $t) {
                $t = trim($t);
                if ($t) $tags[] = ['text' => $t, 'color' => $tagColors[$j] ?? 'b'];
            }
            $projects[] = [
                'name' => $name,
                'desc' => trim($_POST['proj_desc'][$i] ?? ''),
                'url' => trim($_POST['proj_url'][$i] ?? '') ?: '#',
                'tags' => $tags,
            ];
        }
    }

    $travel = [];
    if (!empty($_POST['travel_place'])) {
        foreach ($_POST['travel_place'] as $i => $place) {
            $place = trim($place);
            if ($place) $travel[] = ['place' => $place, 'date' => trim($_POST['travel_date'][$i] ?? ''), 'status' => ($_POST['travel_status'][$i] ?? 'done')];
        }
    }

    $experience = [];
    $services = [];

    $list_data = [
        'skills' => $skills,
        'projects' => $projects,
        'travel' => $travel,
        'experience' => $experience,
        'services' => $services,
    ];

    // === hobby_json ===
    $allocations = [];
    if (!empty($_POST['alloc_name'])) {
        foreach ($_POST['alloc_name'] as $i => $name) {
            $name = trim($name);
            if ($name) $allocations[] = ['name' => $name, 'pct' => intval($_POST['alloc_pct'][$i] ?? 0), 'color' => $_POST['alloc_color'][$i] ?? 'var(--bar1)'];
        }
    }

    $mediaArr = [];
    if (!empty($_POST['media_title'])) {
        foreach ($_POST['media_title'] as $i => $title) {
            $title = trim($title);
            if ($title) $mediaArr[] = ['icon' => trim($_POST['media_icon'][$i] ?? ''), 'title' => $title, 'sub' => trim($_POST['media_sub'][$i] ?? ''), 'progress' => intval($_POST['media_progress'][$i] ?? 0), 'bg' => $_POST['media_bg'][$i] ?? 'var(--amber-dim)'];
        }
    }

    $hobby = [
        'investment' => [
            'returns' => $_POST['inv_returns'] ?? '',
            'total' => $_POST['inv_total'] ?? '',
            'allocations' => $allocations,
        ],
        'media' => $mediaArr,
    ];

    // === system_json ===
    $system = [
        'theme_id' => $_POST['active_theme'] ?? 'default_bento',
        'posts_slug' => $_POST['posts_slug'] ?? 'posts',
        'music' => [
            'enabled' => !empty($_POST['music_enabled']),
            'autoplay' => !empty($_POST['music_autoplay']),
            'playlist' => array_values(array_filter(array_map(function ($line) {
                $line = trim($line);
                if (!$line) return null;
                $parts = explode('|', $line, 2);
                return ['title' => trim($parts[0] ?? '未知'), 'url' => trim($parts[1] ?? '')];
            }, explode("\n", $_POST['music_playlist'] ?? '')), fn($p) => !empty($p['url']))),
        ],
        'custom_header' => $_POST['custom_header'] ?? '',
        'custom_footer' => $_POST['custom_footer'] ?? '',
        'weather' => [
            'enabled' => !empty($_POST['weather_enabled']),
            'city' => $_POST['weather_city'] ?? 'Shanghai',
        ],
        'ext' => (function() {
            $keys = array_filter($_POST['ext_key'] ?? [], fn($k)=>trim($k)!=='');
            $vals = array_map('trim', $_POST['ext_val'] ?? []);
            // 确保键值数量一致
            $result = [];
            for ($i = 0; $i < max(count($keys), count($vals)); $i++) {
                $k = trim($keys[$i] ?? '');
                if ($k !== '') {
                    $result[$k] = $vals[$i] ?? '';
                }
            }
            return $result;
        })(),
    ];

    // === seo_json ===
    $seo = $_POST['seo'] ?? [];

    // === ext_json ===
    $ext = jsonSafe($_POST['extra_raw'] ?? '', []);

    // === blocks_json ===
    $blocks = $_POST['blocks'] ?? [];

    // 保存
    $e = JSON_UNESCAPED_UNICODE;
    $pdo->prepare("UPDATE config_data SET basic_json=?,hero_stats_json=?,social_json=?,list_data_json=?,hobby_json=?,system_json=?,seo_json=?,ext_json=?,blocks_json=?,icp_info=?,footer_copyright=? WHERE id=1")->execute([
        json_encode($basic, $e), json_encode($hero_stats, $e), json_encode($social, $e),
        json_encode($list_data, $e), json_encode($hobby, $e), json_encode($system, $e),
        json_encode($seo, $e), json_encode($ext, $e), json_encode($blocks, $e),
        $_POST['icp_info'] ?? '', $_POST['footer_copyright'] ?? '',
    ]);

    $msg = '配置已保存';
    header('Location: config.php?tab=' . urlencode($tab) . '&msg=' . urlencode($msg));
    exit;
}

// === 读取数据 ===
$CTX = get_full_context($pdo);
$B = $CTX['basic'] ?? [];
$S = $CTX['social'] ?? [];
$L = $CTX['list'] ?? [];
$H = $CTX['hobby'] ?? [];
$SYS = $CTX['system'] ?? [];
$SEO = $CTX['seo'] ?? [];
$EXT = $CTX['ext'] ?? [];
$BLK = $CTX['blocks'] ?? [];

$available_themes = scanThemes();
$active_theme = $SYS['theme_id'] ?? 'default_bento';
$active_theme_data = [];
foreach ($available_themes as $t) {
    if ($t['folder'] === $active_theme) { $active_theme_data = $t; break; }
}

// Tab
$tab = $_GET['tab'] ?? 'basic';

echo render('admin/layout', [
    'title' => '资料配置',
    'page' => 'config',
    'content' => render('admin/config_form', [
        'CTX' => $CTX,
        'B' => $B, 'S' => $S, 'L' => $L, 'H' => $H, 'SYS' => $SYS,
        'SEO' => $SEO, 'EXT' => $EXT, 'BLK' => $BLK,
        'active_theme' => $active_theme,
        'active_theme_data' => $active_theme_data,
        'available_themes' => $available_themes,
        'tab' => $tab,
        'msg' => $_GET['msg'] ?? '',
    ]),
]);
