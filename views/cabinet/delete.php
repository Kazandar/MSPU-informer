<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>

<div class="container" style="padding-bottom: 150px">
    <div class="delete_account">
<form method="post" name="delete" >
    <h1 class="header_form">Форма удаления аккаунта</h1>
    <label for="pass">Чтобы удалить учетную запись введите пароль</label>
    <?php
    if (is_array($this->error))
    {
        foreach ($this->error as $value)
        {
            echo "<p style='color: red;'>$value</p>";
        }
    }
    ?>
    <input type="password" name="pass" id="pass" autofocus>
    <div><input type="submit" name="no" value="Отменить">
    <input type="submit" name="yes" value="Удалить"></div>
</form>
</div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';

