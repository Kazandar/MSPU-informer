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
<div class="container" style="flex-direction: column; align-items: center; justify-content: space-around" >
    <div class="add_event">
        <a href="/admin/manage_events/add"><img src="/template/images/add-icon.png" alt="add_event" ><span>Добавить новую запись</span></a>
        <form  method="post" name="back">
            <p><input type="submit" name="back" value="Назад" id="button"></p>
        </form>

    </div>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Категория</th>
        <th>Заголовок</th>
        <th>Дата публикации</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($event_list as $event): ?>
        <tr>
            <td ><?php echo $event['id']; ?></td>
            <td><?php echo $event['title_category']?></td>
            <td><?php echo $event['title']; ?></td>
            <td><?php echo $event['pub_date']; ?></td>
            <td><a style="margin-left: 5px" href="/admin/manage_events/hide/<?php echo $event['id']; ?>" ><?php if ($event['status'] == 1) echo "<img src=\"/template/images/vis_true.png\" alt=\"hide\" >";else echo "<img src=\"/template/images/vis_false.png\">";?></a></td>
            <td><a style="margin-left: 5px" href="/admin/manage_events/update/<?php echo $event['id']; ?>"><?php echo "<img src=\"/template/images/edit.png\" alt=\"edit\" >";?></a></td>
            <td><a style="margin-left: 5px" href="/admin/manage_events/delete/<?php echo $event['id']; ?>"><?php echo "<img src=\"/template/images/del.png\" alt=\"delete\" >";?></a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';