<div style="margin-bottom:20px">
    <button class="btn primary" onclick="document.getElementById('formPanel').classList.toggle('show'); clearForm()">➕ 发布新动态</button>
    <a class="btn" href="generate.php">🚀 生成静态页</a>
</div>

<div id="formPanel" class="card form-panel <?php if(!empty($edit_article) || !empty($show_form))echo 'show'?>">
    <h3><?= !empty($edit_article) ? '编辑动态' : '发布新动态' ?></h3>
    <form method="post">
        <input type="hidden" name="id" id="editId" value="<?= $edit_article['id'] ?? 0 ?>">
        <div class="row">
            <div class="field" style="grid-column:span 2"><label>标题</label><input name="title" id="editTitle" value="<?=h($edit_article['title']??'')?>" required></div>
            <div class="field"><label>类型</label>
                <select name="type" id="editType">
                    <?php foreach($types as $k=>$v):?><option value="<?=$k?>" <?=($edit_article['type']??'dynamic')==$k?'selected':''?>><?=$v?></option><?php endforeach?>
                </select>
            </div>
        </div>
        <div class="field"><label>摘要 <small style="color:var(--muted)">（主页显示的简短描述）</small></label><input name="summary" id="editSummary" value="<?=h($edit_article['summary']??'')?>"></div>
        <div class="field"><label>正文 <small style="color:var(--muted)">（详情页完整内容，支持HTML）</small></label><textarea name="content" id="editContent"><?=h($edit_article['content']??'')?></textarea></div>
        <div class="field" style="width:200px"><label>发布时间</label><input name="add_time" type="datetime-local" value="<?=($edit_article['add_time']??date('Y-m-d H:i:s'))?>"></div>
        <div style="margin-top:16px">
            <button class="btn primary" type="submit">💾 <?= !empty($edit_article) ? '保存修改' : '发布动态' ?></button>
            <button class="btn" type="button" onclick="document.getElementById('formPanel').classList.remove('show')">取消</button>
        </div>
    </form>
</div>

<div class="card">
    <h3>动态列表</h3>
    <?php if(!empty($articles)): ?>
    <table><thead><tr><th>ID</th><th>标题</th><th>类型</th><th>时间</th><th>操作</th></tr></thead>
    <tbody>
    <?php foreach($articles as $a): ?>
    <tr>
        <td><?=$a['id']?></td>
        <td><?=h($a['title'])?></td>
        <td><?=$types[$a['type']]??$a['type']?></td>
        <td><?=$a['add_time']?></td>
        <td class="actions">
            <a href="?edit=<?=$a['id']?>" onclick="loadEdit(<?=$a['id']?>,'<?=addslashes($a['title'])?>','<?=addslashes($a['summary'])?>','<?=addslashes($a['content'])?>','<?=$a['type']?>')">编辑</a>
            <a href="?del=<?=$a['id']?>" onclick="return confirm('确定删除？')">删除</a>
        </td>
    </tr>
    <?php endforeach?>
    </tbody></table>
    <?php else:?><p style="color:var(--muted);padding:20px;text-align:center">暂无动态，点击上方按钮发布第一条</p><?php endif;?>
</div>
<script>
function clearForm(){document.getElementById('editId').value='0';document.getElementById('editTitle').value='';document.getElementById('editSummary').value='';document.getElementById('editContent').value='';document.getElementById('editType').value='dynamic'}
function loadEdit(id,title,summary,content,type){document.getElementById('editId').value=id;document.getElementById('editTitle').value=title;document.getElementById('editSummary').value=summary;document.getElementById('editContent').value=content;document.getElementById('editType').value=type;document.getElementById('formPanel').classList.add('show')}
</script>