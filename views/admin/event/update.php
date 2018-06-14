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
<?php if (is_array($this->error) and !empty($this->error))
{
    echo '<p>Форма не отправлена</p>';
    foreach ($this->error as $value)
        echo "<p>$value</p>";
} ?>
<div class="container">
<div class="add_event" style="width:700px" >
<form method="post" name="add_event" enctype="multipart/form-data" style="margin-top: 2vh; display: flex;flex-direction: column;align-items: center; justify-content: space-around;width: 100%">
    <label for="list" style="margin-top: 2vh;width: 50%; align-self: center">Категория</label>
    <select id="list" name="category" style="width: 50%">
        <?php if (is_array($category_list)): ?>
            <?php foreach ($category_list as $category): ?>
                <option  value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $data['id_category']) echo "<selected>"; ?>>
                    <?php echo $category['title']; ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <label for="header" style="margin-top: 2vh;width: 50%">Заголовок</label>
    <input type="text" id="header" name="title" value="<?php echo $data['title']?>" style="width: 50%;height: 2em;background-color: white;color: black" required autofocus>
    <label style="margin-top: 2vh;" for="image">Картинка</label>
    <?php echo "<div><img src=$img width=\"200\" alt=\"upload_image\"></div>";?>
    <input type="file" name="review" id="image" style="margin-top: 2vh;width: 50%;height: 1.6em;background-color: white;color: black">
    <label style="margin-top: 2vh;" for="short_content">Краткое описание</label>
    <textarea name="short_content" id="short_content" rows="15" style="width: 100%" required> <?php echo $data['short_content']?> </textarea>
    <label style="margin-top: 2vh;" for="full_content">Полный текст</label>
    <textarea id="full_content" rows="20" style="width: 120%" name="content" required><?php echo $data['content']?></textarea>
    <label style="margin-top: 2vh;" for="address">Адрес</label>
    <input id="address" type="text" name="address" style="width: 30%;background-color: white;color: black" value="<?php echo $data['address']?>" required>
    <label style="margin-top: 2vh;" for="date">Дата события</label>
    <input id="date" type="date" name="date" style="width: 30%;background-color: white;color: black" value="<?php echo $data['event_date']?>" required>
    <input type="submit" name="add" value="Изменить" style="margin-top: 2vh;height: 2em">
</form>
<form style="width: 700px; text-align: center" method="post" name="back_event">
    <input type="submit" style="margin: 2vh 0 5vh 0;height: 2em" name="back" value="Отменить">
</form>
</div>
</div>
<?php include_once ROOT.'/views/layouts/footer.php';