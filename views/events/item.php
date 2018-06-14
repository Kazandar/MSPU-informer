<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container">
    <div class="event_item">
        <h1><?php echo "$eventItem[title]" ?></h1>
        <p>Категория: <?php foreach ($title_category as $cat) echo "<a href='/events/$cat[title_translit]'>$cat[title]</a>"?></p>
        <hr>
        <div><?php if (file_exists(ROOT."/upload/images/events/$eventItem[id].jpg"))
            echo "<img src=\"/upload/images/events/$eventItem[id].jpg\" alt=\"event-image\">"; else echo "<span></span>"?>
        <p><?php echo "$eventItem[content]" ?></p></div>
        <p><span style="font-size: 26px; color:black">Дата и время проведения: </span><?php echo "$eventItem[event_date]" ?></p>
        <p><span style="font-size: 26px; color:black">Адрес: </span><?php echo "$eventItem[address]" ?></p>
        <?php if(!isset($_SESSION['user'])) echo "<div id='button'><p>Авторизуйтесь, что-бы принять участие</p></div>"?>
        <?php if ($status === false and isset($_SESSION['user']) ): ?>
            <form method="post" name="item">
                <p><label><input style="background-color: lightgreen" type="submit" name="write" value="Принять участие"></label></p>
            </form>
        <?php endif; ?>
        <?php if ($status === true and isset($_SESSION['user'])): ?>
            <form method="post" name="item">
                <input style="background-color: red" type="submit" name="cancel" value="Отменить">
            </form>
        <?php endif; ?>
    </div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';
