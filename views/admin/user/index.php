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
    <div class="header_manager_user">
<form method="post" name="searcher">
    <label for="search">Поиск по mail</label>
    <input type="email" name="mail_search" id="search" required>
    <input type="submit" name="search" value="Поиск">
</form>
<form method="post" action="" name="user_controller">
       <input type="submit" name="back" value="Назад">
</form>
    </div>
        <table class="table" style="width: 700px">
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Почта</th>
        <th>Роль</th>
        <th>Статус</th>
        <th>Права доступа</th>
    </tr>
    <?php if ($info == false) echo '<p style="color: red; font-size: 20px;margin-bottom: 5vh;margin-top: 5vh">Пользователь с таким почтовым адресом не обнаружен</p>'; else { $i = 0; foreach ($info as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo ucfirst($user['surname']).' '.ucfirst(substr($user['name'],0,2)).'.'.ucfirst(substr($user['patronymic'],0,2)).'.'; ?></td>
            <td><?php echo $user['mail'];?></td>
            <td><?php echo $role_title_list[$i];$i++; ?></td>
            <td><a href="/admin/manage_users/block/<?php echo $user['id']; ?>"><?php if ($user['id_role'] == 1)echo "<img src=\"/template/images/banned.png\" alt=\"banned\" >";else echo "<img src=\"/template/images/unbanned.png\" >";?></a></td>
            <td><a href="/admin/manage_users/role/<?php echo $user['id']; ?>"><?php echo "<img src=\"/template/images/secured.png\" alt=\"change-role\" >"?></a></td>
        </tr>
    <?php endforeach; }?>
</table>
    </div>
<?php include_once ROOT.'/views/layouts/footer.php';