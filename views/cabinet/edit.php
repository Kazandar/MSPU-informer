<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container"  style="align-items: center">
    <div class="edit-form">
        <?php
        if (is_array($this->error))
        {
            foreach ($this->error as $value)
            {
                echo "<p style='color: red; text-align: center;margin-top: 30px'>$value</p>";
            }
        }
        ?>
    <form method="post" name="edit">
        <div class="header_form"><h1>Редактировать данные</h1></div>
        <div style="margin-top: 5px">Секция смены ФИО</div>
        <div><label for="first_field">Имя</label>
            <input type="text" name="name" value="<?php echo $_SESSION['name']?>" id="first_field" required></div>
        <div><label for="second_field">Фамилия</label>
            <input type="text" name="surname" id="second_field" value="<?php echo $_SESSION['surname']?>" required></div>
        <div><label for="third_field_field">Отчество</label>
            <input type="text" name="patronymic" id="third_field_field" value="<?php echo $_SESSION['patronymic']?>" required></div>
        <div id="line"></div>
        <div style="margin-top: 5px">Секция смены почтового адреса</div>
        <div><label for="fourth_field">Ваша текущая почта:</label>
                <input type="email" name="old_email" value="<?php echo $this->mail_user ?>" id="fourth_field" readonly></div>
        <div><label for="fifth_field">Введите новую почту:</label>
            <input type="email" name="new_mail" id="fifth_field"></div>
        <div id="line"></div>
        <div style="margin-top: 5px">Секция смены пароля</div>
        <div><label for="sixth_field">Введите ваш новый пароль:</label>
            <input type="password" name="new_pass1" id="sixth_field"></div>
        <div><label for="seventh_field">Повторите новый пароль:</label>
            <input type="password" name="new_pass2" id="seventh_field"></div>
        <div id="line"></div>
        <div style="margin-top: 5px">Секция подтверждения</div>
        <div><label for="eight_field">Введите ваш старый пароль:</label>
            <input type="password" name="old_pass" id="eight_field" required></div>
            <input type="submit" name="edit" value="Изменить" id="button">
    </form>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';