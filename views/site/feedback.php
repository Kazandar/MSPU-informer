<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
   <div class="container">
        <div class="feedback">
            <h1>Свяжитесь с нами</h1>
            <p>Что бы уточнить детали по проведению мероприятий, звоните или пишите нам.</p><br>
            <?php if (isset($result) and $result === false)
            {
                echo "<span style='color: red;'>Сообщение не удалось отправить, свяжитесь с нами по телефону</span>";
            }
            if (isset($result) and $result === true)
            {
                echo "<span style='color: green;'>Сообщение успешно отправлено!</span>";
            }
            ?>
           <form method="post" action="#" name="contact_form"><hr>
               <label for="first_field">Имя <span style="color: red">*</span></label>
               <input type="text" required id="first_field" name="name" value="<?php if (isset($_SESSION) and !empty($_SESSION)) echo $_SESSION['name'];?>">
               <label for="second_field">Ваш e-mail <span style="color: red">*</span></label>
               <input type="email" name="mail" required id="second_field" value="<?php if (isset($_SESSION) and !empty($_SESSION)) echo $_SESSION['mail'];?>">
               <label for="third_field">Тема</label>
               <input type="text" name="theme" id="third_field">
               <label for="fourth_field"> Сообщение</label>
               <textarea rows="20" cols="50" id="fourth_field" name="message"></textarea>
               <input type="submit" name="feedback" value="Отправить">
           </form>
        </div>
   </div>
<?php include_once ROOT.'/views/layouts/footer.php';
