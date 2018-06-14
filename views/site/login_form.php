<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<?php
    if ($session_exist === true)
    {
        echo '<p>Вы успешно авторизованы!</p>';
        return;
    }
?>
<div class="container" style="align-items: center;">
    <div class="login-form">
        <?php
        if (is_array($this->error))
        {
            foreach ($this->error as $value)
            {
                echo "<p style='color: red; text-align: center; position: relative;bottom: 3vh;margin-top: 1vh'>$value</p>";
            }
        }
        ?>
        <form method="post" name="login">
            <div class="header_form"><h1>Вход на сайт:</h1></div>
            <div><label for="first_field">Введите логин(эл.почта)</label>
            <input type="email" name="mail" id="first_field" value="<?php if (isset($_COOKIE['login'])) echo $_COOKIE['login']?>"  autofocus></div>
            <div><label for="second_field">Введите пароль</label>
            <input type="password" name="pass" value="<?php if (isset($_COOKIE['pass'])) echo $_COOKIE['pass']?>" id="second_field" ></div>
            <div class="auth">
            <label id="remember_label">Запомнить меня<input type="checkbox" name="remember" id="remember" value="selected" checked></label>
            <input type="submit" name="login" value="Войти" id="button"></div>
            <input type="submit" name="register" value="Зарегистрироваться" id="button2">
            <input type="submit" name="cancel" value="Отменить" id="button3">
        </form>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';