<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
<div class="container">
    <? include_once ROOT . '/views/layouts/aside.php';?>
    <main>
        <h1>Последние новости:</h1>
            <?php if (is_array($eventsListForIndex) and !empty($eventsListForIndex))
            foreach($eventsListForIndex as $event):?>
        <article>
            <?php if (file_exists(ROOT."/upload/images/events/$event[id].jpg"))
                    echo "<img src=\"/upload/images/events/$event[id].jpg\" alt='event_photo' >";
                else
                    echo "<img src=\"/upload/images/events/no-image.jpg\" alt='no_image' > ";?>
            <h2><?php echo $event['title'] ?></h2>
            <p><?php echo $event['short_content'] ?></p>
            <a href="<?php echo "events/$event[title_category]/$event[id]"; ?>">Подробнее...</a>
        </article>
            <?php endforeach; else echo "<div class='empty' style='margin-top: 45px'>Не обнаружено ни одной записи</div>"  ?>
    </main>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';