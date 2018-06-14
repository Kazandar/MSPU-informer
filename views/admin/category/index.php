<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<?  if($status === false)
{
    echo '<p>В доступе отказано</p>';
    exit;
}
if($status === 1)
{
    echo '<p>Вы были заблокированы администрацией сайта</p>';
    exit;
}
if($status === 2 or $status === 3)
{
    echo '<p>У вас нет прав</p>';
    exit;
}
?>
    <div class="container" style="flex-direction: column; align-items: center; justify-content: flex-start" >
    <div class="add_event" style="width: 400px">
    <a href="/admin/manage_categories/add"><img src="/template/images/add-icon.png" alt="add_cat" ><span>Добавить новую категорию</span></a>
    <form method="post" name="back">
        <p><input type="submit" name="back" value="Назад" id="button"></p>
    </form></div>
<table class="table" style="width: 400px;">
    <tr>
        <th>Наименование</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($cat_list as $cat): ?>
        <tr>
            <td><?php echo $cat['title']; ?></td>
            <td><a href="/admin/manage_categories/hide/<?php echo $cat['title_translit'] ?>"><?php if ($cat['status'] == 1)echo "<img src=\"/template/images/vis_true.png\" alt=\"hide\" >";else echo "<img src=\"/template/images/vis_false.png\">";?></a></td>
            <td><a href="/admin/manage_categories/update/<?php echo $cat['title_translit'] ?>"><?php echo "<img src=\"/template/images/edit.png\" alt=\"edit\" >";?></a></td>
            <td><a href="/admin/manage_categories/delete/<?php echo $cat['title_translit'] ?>"><?php echo "<img src=\"/template/images/del.png\" alt=\"delete\" >";?></a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';