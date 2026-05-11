<?php
/**
 * 动态管理控制器
 */
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../config/config.php';

session_start();
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }

$pdo = getDB();
$msg = '';
$edit_article = null;
$show_form = !empty($_GET['new']);

// 删除
if (!empty($_GET['del'])) {
    $pdo->prepare("DELETE FROM articles WHERE id=?")->execute([intval($_GET['del'])]);
    $msg = '删除成功';
}

// 编辑获取
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id=?");
    $stmt->execute([intval($_GET['edit'])]);
    $edit_article = $stmt->fetch();
    $show_form = true;
}

// 保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $type = trim($_POST['type'] ?? 'dynamic');
    $add_time = $_POST['add_time'] ?? date('Y-m-d H:i:s');
    
    if ($title) {
        if ($id) {
            $pdo->prepare("UPDATE articles SET title=?,summary=?,content=?,type=?,add_time=? WHERE id=?")
                ->execute([$title, $summary, $content, $type, $add_time, $id]);
            $msg = '修改成功';
        } else {
            $pdo->prepare("INSERT INTO articles (title,summary,content,type,add_time) VALUES (?,?,?,?,?)")
                ->execute([$title, $summary, $content, $type, $add_time]);
            $msg = '发布成功';
        }
    }
}

$articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC")->fetchAll();
$types = ['dynamic'=>'日常动态', 'work'=>'工作', 'life'=>'生活', 'travel'=>'旅行', 'tech'=>'技术'];

echo render('admin/layout', [
    'page' => 'articles',
    'title' => '动态管理',
    'page_title' => '动态管理',
    'msg' => $msg,
    'content' => render('admin/articles_list', [
        'articles' => $articles,
        'types' => $types,
        'edit_article' => $edit_article,
        'show_form' => $show_form
    ])
]);