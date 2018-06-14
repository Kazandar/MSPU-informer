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
<div class="container">
    <div class="add_event" style="justify-content: space-around">
<h1 style="font-size: 1.8em">Вы действительно хотите удалить запись № <?echo $id?> ?</h1>
<form method="post" name="delete_event" style="display: flex; justify-content: space-around; width: 100%">
    <input style="height: 2em;background-color: red" type="submit" name="yes" value="Удалить">
    <input style="height: 2em" type="submit" name="cancel" value="Назад">
</form>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';