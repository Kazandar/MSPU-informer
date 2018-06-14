<?php
if (isset($_SESSION['user'])) include_once ROOT . '/views/layouts/header_user.php';
else include_once ROOT . '/views/layouts/header_guest.php';
?>
    <div class="container">
        <div class="admin-main">
            <h1>Панель управления сайтом:</h1>

        <form method="post">
            <input type="submit" name="manage_events" value="Управление записями">
            <input type="submit" name="manage_categories" value="Управление категориями">
            <input type="submit" name="manage_users" value="Управление пользователями">
            <input type="submit" name="statistics" value="Статистика">
        </form>
        </div>
    </div>


<?php include_once ROOT.'/views/layouts/footer.php';