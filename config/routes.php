<?php
    return[
        '^archive/page-([0-9]+$)' => 'events/archiveList/$1',//Список всех прошедших мероприятий постранично
        '^events/([a-zA-Z]+)/page-([0-9]+$)' => 'events/eventCategory/$1/$2',//Постраничный вывод всех событий в конкретной категории
        '^events/page-([0-9]+$)' => 'events/eventList/$1',//Постраничный вывод всех событий без учета категорий
        '^events/([a-zA-Z]+)/([0-9]+$)' => 'events/event/$1/$2',//Страница конкретного события
        '^events/([a-zA-Z]+$)' => 'events/eventCategory/$1',//Список всех мероприятий в конкретной категории
        '^cabinet/edit$' => 'cabinet/edit',//Страница смена данных пользователя
        '^cabinet/delete$' => 'user/deleteAccount',//Удаление учетной записи
        '^cabinet$' => 'cabinet/index',//Главная страница кабинета
        '^cabinet/my_events$' => 'cabinet/myEvents',//Список мероприятий на которые записался пользователь
        '^register$' => 'user/register',//Регистрация нового пользователя
        '^login$' => 'user/login',//Вход в уже существующий аккаунт
        '^logout$' => 'user/logout',//Выход из аккаунта
        '^about$' => 'site/about',//Страница о нас
        '^feedback$' => 'site/feedback',//Форма обратной связи
        '^archive$' => 'events/archiveList',//Список всех прошедших мероприятий
        '^events$' => 'events/eventList',//Спискок всех мероприятий без учета категорий
        '^admin/manage_categories/add$' => 'admin/addCategories',//Создание категории
        '^admin/manage_categories/update' => 'admin/updateCategory',//изменение существующей категории
        '^admin/manage_categories/delete' => 'admin/deleteCategory',//Удаление категории
        '^admin/manage_categories/hide' => 'admin/hideCategory',//Удаление категории
        '^admin/manage_categories$' => 'admin/manageCategories',//Управление категориями
        '^admin/manage_events$' => 'admin/manageEvents',//Управление записями
        '^admin/manage_events/add$' => 'admin/addEvent',//Добавить новую запись
        '^admin/manage_events/delete' => 'admin/deleteEvent',//Удалить запись
        '^admin/manage_events/update' => 'admin/updateEvent',//Изменить запись
        '^admin/manage_events/hide' => 'admin/hideEvent',//Изменить запись
        '^admin/manage_users$' => 'admin/manageUsers',//Управление пользователями
        '^admin/manage_users/block' => 'admin/blockUser',//Заблокировать пользователя
        '^admin/manage_users/role' => 'admin/roleUser',//Изменить права
        '^admin/statistics$' => 'admin/statistics',//Статистика
        '^admin/statistics/user_list' => 'admin/userList',//Статистика
        '^admin$' => 'admin/index',//Спискок всех мероприятий без учета категорий
        '^$' => 'site/index'//Главная страница
    ];