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
if($status === 2)
{
    echo '<p>У вас нет прав</p>';
    exit;
}
?>
<div class="container" style="flex-direction: column; align-items: center; justify-content: space-around" >
<div class="add_event" style="width: 900px;justify-content: space-between">
    <h1 style="font-size: 1.5em">Статистика по мероприятиям:</h1>
    <form method="post" name="back">
        <input type="submit" name="back" value="Назад">
    </form>
</div>
<table class="table" style="width: 900px">
    <tr>
        <th>ID</th>
        <th>Категория</th>
        <th>Заголовок</th>
        <th>Дата проведения</th>
        <th>Кол-во участников</th>
        <th>Список участников</th>
        <th></th>
    </tr>
    <?php $x = 0; foreach ($event_list as $event): ?>
        <tr>
            <td><?php echo $event['id']; ?></td>
            <td><?php echo $event['title_category'];?></td>
            <td><?php echo $event['title']; ?></td>
            <td><?php echo $event['event_date']; ?></td>
            <td style="text-align: center"><?php echo $count[$x]; $x++; ?></td>
            <td><a href="/admin/statistics/user_list/<?php echo $event['id']; ?>"><?php echo "<img style='width: 35px'  src=\"/template/images/list.png\" alt=\"get_list\" >";?></a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';