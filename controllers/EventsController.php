<?php

    class eventsController
    {
        //Вывод всех прошедших мероприятий
        public function actionArchiveList($page = 1)
        {
            $archiveList = array();
            $archiveList = Events::getArchiveList($page);
            $categoriesList = array();
            $categoriesList = Categories::getCategoriesList();
            $total = Events::getTotalCountArchive();
            $count_view = Events::SHOW_BY_DEFAULT;
            $pagination  = new Pagination($total,$page,Events::SHOW_BY_DEFAULT,'page-');

            include_once ROOT.'/views/events/archive.php';
        }


        //Вывод всех новостей всех категорий
        public function actionEventList($page = 1)
        {
            $eventsList = array();
            $eventsList = Events::getEventList($page);
            $categoriesList = array();
            $categoriesList = Categories::getCategoriesList();
            $total = Events::getTotalCount();
            $count_view = Events::SHOW_BY_DEFAULT;
            $pagination  = new Pagination($total,$page,Events::SHOW_BY_DEFAULT,'page-');

            include_once ROOT.'/views/events/all.php';

        }
        //Вывод всех новостей в конкретной категории
        public function actionEventCategory($title,$page = 1)
        {
            $eventListByCategory = Events::getEventListByCategory($title,$page);
            $title_rus = Categories::getRusCategoryTitleByTitle($title);

            $categoriesList = array();
            $categoriesList = Categories::getCategoriesList();
            $total = Events::getTotalCountInCategory($title);
            $count_view = Events::SHOW_BY_DEFAULT;
            $pagination  = new Pagination($total,$page,Events::SHOW_BY_DEFAULT,'page-');

            include_once ROOT.'/views/events/category.php';
        }
        //Вывод конкретной новости
        public function actionEvent($title,$id)
        {
            $categoriesList = array();
            $categoriesList = Categories::getCategoriesList();
            if(empty($_SESSION['user']))
                $user_id = 0;
            else
                $user_id = $_SESSION['user'];
            $status = User::CheckEvent($user_id,$id);
            if (isset($_POST['write']))
            {
               User::addEvent($user_id,$id);
               Events::addUserForEvent($user_id,$id);
                echo  "<meta http-equiv=\"refresh\" content=\"0; url=http://mathfaculty-mpgu.com/events/$title/$id\">";
            }
            if (isset($_POST['cancel']))
            {
                User::DeleteEventByUser($user_id,$id);
                Events::DeleteEventByUser($user_id,$id);
                echo  "<meta http-equiv=\"refresh\" content=\"0; url=http://mathfaculty-mpgu.com/events/$title/$id\">";
            }
            $eventItem = Events::getEventById($title,$id);
                $cat_id =  $eventItem['id_category'];
                $title_category = Categories::getCategoryTitleById($cat_id);

            include_once ROOT . '/views/events/item.php';

        }

    }