<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container">
    <div class="add_event" style="flex-direction: column">
        <h1 style="font-size: 1.4em">Вы действительно хотите удалить категорию <?echo $title_rus?> ?</h1>
        <form method="post" name="delete_cat" style="display: flex; flex-direction: row; justify-content: space-between; width: 50%">
            <input style="background-color: red; height: 2em" type="submit" name="yes" value="Удалить">
            <input style="height: 2em" type="submit" name="back" value="Назад">
        </form>
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
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';