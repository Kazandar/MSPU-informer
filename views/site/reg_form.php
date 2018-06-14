<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<?php
    if ($session_exist === TRUE)
    {
     echo '<p>Вы уже зарегистрированы!</p>';
        return;
    }
?>
    <div class="container"  style="align-items: center">
        <div class="reg-form">
            <?php
            if (is_array($this->error))
            {
                foreach ($this->error as $value)
                {
                    echo "<p style='color: red;text-align:center;margin-top: 1vh'>$value</p>";
                }
            }

            ?>
            <form method="post" name="reg">
                <div class="header_form"><h1>Заполните форму регистрации</h1></div>
                <div><label for="first_field_field">Ваше имя</label>
                    <input type="text" name="name" id="first_field_field" autofocus required></div>
                <div><label for="second_field">Ваше отчество</label>
                    <input type="text" name="patronymic" id="second_field"></div>
                <div><label for="third_field_field">Ваша фамилия</label>
                    <input type="text" name="surname" id="third_field_field" required></div>
                <div><label for="fourth_field">Ваш mail(используется для входа)</label>
                    <input type="email" name="mail" id="fourth_field" value="<?php echo $this->mail ?>" required></div>
                <div><label for="fifth_field">Введите пароль</label>
                    <input type="password" name="pass" id="fifth_field" required></div>
             <div><label for="sixth_field">Повторите пароль</label>
                    <input type="password" name="pass2" id="sixth_field" required></div>
                    <input type="submit" name="register" value="Зарегистрироваться" id="button">
            </form>
        </div>
    </div>
<?php include_once ROOT.'/views/layouts/footer.php';