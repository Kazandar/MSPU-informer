<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
    <div class="container">
        <main>
            <h1>Архив мероприятий</h1>
            <?php if (is_array($archiveList) and !empty($archiveList))
            foreach($archiveList as $event):?>
                <article>
                    <?php if (file_exists(ROOT."/upload/images/events/$event[id].jpg"))
                        echo "<img src=\"/upload/images/events/$event[id].jpg\" alt=\"event-image\" >";
                    else
                        echo "<img src=\"/upload/images/events/no-image.jpg\" alt=\"no-image\" > ";?>
                    <h2><?php echo $event['title'] ?></h2>
                    <p><?php echo $event['short_content'] ?></p>
                    <a href="<?php echo "/events/$event[title_category]/$event[id]"; ?>">Подробнее...</a>
                </article>
            <?php endforeach; else echo "<div class='empty'>Не обнаружено ни одной записи</div>"?>
            <div class="pagination"><?php if($total > $count_view) echo $pagination->get();  ?></div>
        </main>
    </div>
<?php include_once ROOT.'/views/layouts/footer.php';