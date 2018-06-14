<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>

<div class="container" style="flex-direction: column; justify-content: flex-start; align-items: center">
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
    <div class="add_event" style="flex-direction: column">
        <h1><?php echo "Выберите роль пользователя $mail";?></h1>
<form method="post" name="role_change">
    <select style="width: 150px; height: 3vh ;background-color: lightyellow" name="role">
        <?php if (is_array($role_list)): ?>
            <?php foreach ($role_list as $role): ?>
                <option value="<?php echo $role['id']; ?>">
                    <?php echo $role['title']; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <input type="submit" name="yes" value="Выбрать">
    <input type="submit" name="back" value="Назад">
</form>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';