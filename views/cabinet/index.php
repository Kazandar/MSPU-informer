<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container">
    <div class="cabinet">
        <p style="font-size: 24px;text-align: center;margin-bottom: 1.5vh"><b>Личный кабинет:</b> <?php echo $_SESSION['surname'].' '.ucfirst(substr($_SESSION['name'],0,2)).'.'.ucfirst(substr($_SESSION['patronymic'],0,2)).'.';?></p>
<?php
if($status === 1)
{
    echo '<p style="font-size: 19px;text-align: left">Вы были заблокированы администрацией сайта</p>';
    exit;
}
if($status === 2)
{
    echo '<p style="font-size: 19px;text-align: center"><b>Вы авторизованы как</b>: студент</p>';
}
if($status === 3)
{
    echo '<p style="font-size: 19px;text-align: center">Вы авторизованы как преподователь</p>';
}
if($status === 4)
{
    echo '<p style="font-size: 19px;text-align: center">Вы авторизованы как администратор</p>';
}
?>

        <form method="post" name="cabinet">
            <?php if ($status === 3) echo "<input type=\"submit\" name=\"statistic\" value=\"Статистика\">";?>
            <?php if ($status === 4) echo "<input type=\"submit\" name=\"admin_panel\" value=\"Панель управления сайтом\">";?>
            <input type="submit" name="my_events" value="Принимаю участие">
            <input type="submit" name="edit" value="Редактировать данные">
            <input type="submit" name="logout" value="Выйти из аккаунта">
            <input type="submit" name="delete" value="Удалить профиль">
        </form>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';
