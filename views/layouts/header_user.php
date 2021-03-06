<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/template/css/normalize.css">
    <link rel="stylesheet" href="/template/css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MSPU-news</title>
</head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".js").click(function(){
        $(".js").hide();
        $(".hide").hide();
        $(".door").removeClass('active-one').addClass('inactive');
        $(".main-menu .menu .sub_menu").removeClass('active-two');
        $(".main-menu .menu").removeClass('active-three');
    });

    $(".door").click(function(){
        $(".js").show();
        $(".hide").show();
        $(".door").removeClass('inactive').addClass('active-one');

    });

    $("#events").click(function(){
        $(".main-menu .menu .sub_menu").addClass('active-two');
        $(".main-menu .menu").addClass('active-three');
        $(".js").show();
    });
});
</script>
<header>
    <section class="first">
        <div class="faculty">
            <a href="/">Faculty of Mathematics MSPU</a>
        <div class="door">
            <a><img src="/template/images/account.png" alt="account" height="45"></a>
            <a><?php echo $_SESSION['name'].' '.$_SESSION['surname'];?><span>&#171;</span></a>
                    <ul class="hide">
                        <li><a href="/cabinet">Личный кабинет</a></li>
                        <?php
                                if ($_SESSION['role'] === 3) echo "<li><a href=\"/admin/statistics\">Статистика</a></li>";
                                    if ($_SESSION['role'] === 4) echo "<li><a href=\"/admin\">Админ панель</a></li>";
                                        else echo "<li><a href=\"/cabinet/my_events\">Принимаю участие</a></li>";?>
                        <li><a href="/cabinet/edit">Редактировать данные</a></li>
                        <li><a href="/logout">Выйти</a></li>
                    </ul>
        </div>
        <div class="js"></div>
            <div class="mobile-menu">
                <input type="checkbox" id="hmt" class="hidden-menu-ticker">
                <label class="btn-menu" for="hmt">
                    <img src="/template/images/mobile-menu.png" alt="mobile_menu" width="40">
                    <img src="/template/images/close-mobile-menu.png" alt="mobile_menu" width="30">
                </label>
                <div class="hidden-menu-wrapper">
                    <label class="hidden-menu-overlay" for="hmt"></label>
                <ul class="hidden-menu">
                    <li><a href="/">Главная</a></li>
                    <li><a href="/cabinet">Личный кабинет</a></li>
                    <li><a href="/events">Мероприятия</a>
                    <li><a href="/archive">Архив</a></li>
                    <li><a href="/about">О нас</a></li>
                    <li><a href="/feedback">Обратная связь</a></li>
                </ul>
            </div>
        </div>
        </div>
    </section>

        <nav class="main-menu">
            <ul class="menu">
                <li><a href="/">Главная</a></li>
                <li><a href="/events">Мероприятия</a><span id="events">&#9660;</span>
                    <ul class="sub_menu">
                        <?php foreach ($categoriesList as $cat):?>
                            <li><a href="<?php echo "/events/$cat[title_translit]" ?>"><?php echo $cat['title'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="http://mpgu.su/" target="_blank"><img class="logo" src="/template/images/logo.png" width="150" alt="logo"></a></li>
                <li><a href="/archive">Архив</a></li>
                <li><a href="/about">О нас</a></li>
                <li><a href="/feedback">Обратная связь</a></li>
            </ul>
        </nav>

</header>