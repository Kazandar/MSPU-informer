<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';?>

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
<?php if (is_array($this->error) and !empty($this->error))
{
    echo '<p>Форма не отправлена</p>';
    foreach ($this->error as $value)
        echo "<p>$value</p>";
} ?>
    <div class="container">
    <div class="add_event" style="flex-direction: column">
<form method="post" name="add_cat" style="display: flex; flex-direction: column; justify-content: space-around;align-items: left">
    <label style="align-self: center;font-size: 1.2em;margin-top: 2vh" for="cat_name">Введите название категории</label>
        <input id="cat_name" type="text" name="title" style="width: 100%; background-color: white;color: black" value="<?php echo $title_rus?>" required autofocus>
    <label style="margin-top: 1vh" for="order_num">Порядковый номер в списке выдачи</label>
        <input id="order_num" type="number" name="order_category" style="width: 25%; background-color: white;align-self: center;color: black" value="<?php echo $order_category?>" required>
    <input type="submit" name="change" value="Изменить" style="align-self: center; margin-top: 2vh">
</form>
        </form>
        <form method="post" action="" name="back" style="display: flex; flex-direction: column; justify-content: space-around;align-items: left;margin-top: 1vh">
            <input type="submit" name="back" value="Назад">
        </form>
    </div>
    </div>
<?php include_once ROOT.'/views/layouts/footer.php';