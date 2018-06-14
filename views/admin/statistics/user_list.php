<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container" style="flex-direction: column; justify-content: flex-start; align-items: center">
    <div class="add_event" style="">
        <h1 style="font-size: 1.5em"><?php echo ($event['title'])?></h1>
        <form method="post" name="back">
            <input type="submit" name="back" value="Назад">
        </form>
    </div>
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

<table class="table">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Cтатус</th>
        <th>Почтовый адресс</th>
    </tr>
    <?php if (empty($user_list)) echo "<p style='color: red; margin-bottom: 1vh'>Ни один пользователь пока не записался на $event[title]</p>";else {$i = 0;foreach ($user_list as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo ucfirst($user['surname']).' '.ucfirst(substr($user['name'],0,2)).'.'.ucfirst(substr($user['patronymic'],0,2)).'.'; ?></td>
            <td><?php echo $role_title_list[$i];?></td>
            <td><?php echo $user['mail'];$i++ ?></td>
        </tr>
    <?php endforeach;} ?>
</table>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';