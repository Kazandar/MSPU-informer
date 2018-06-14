<?php

    class Events
    {
        const SHOW_BY_DEFAULT = 5;

        public static function getEventByIdForAdmin($id)
        {
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id_category`,`title`,`short_content`,`content`,`address`,`event_date` FROM `Event` WHERE `id` = :id");
            $result->execute(array('id' => $id));
            $row = $result->fetch();
            return $row;
        }

        public static function getEventListForAdmin()
        {
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id`,`id_category`,`title`,`pub_date`,`event_date`,`status`,`id_users` FROM `Event` ORDER BY `id` DESC");
            $result->execute(array());
            $i = 0;
            $eventList = false;
            while ($row = $result->fetch()) {
                $eventList[$i]['id'] = $row['id'];
                $test = $link->prepare("SELECT `title` FROM `category` WHERE `id` = :id");
                $test->execute(array('id' => $row['id_category']));
                $string = $test->fetch();
                $eventList[$i]['title_category'] = $string['title'];
                $eventList[$i]['title'] = $row['title'];
                $eventList[$i]['pub_date'] = $row['pub_date'];
                $eventList[$i]['event_date'] = $row['event_date'];
                $eventList[$i]['status'] = $row['status'];
                $eventList[$i]['id_users'] = $row['id_users'];
                $i++;
            }
             return $eventList;
        }
        public static function getTotalCountArchive()
        {
            $total = false;
            $link = db::getConnection();
            $result = $link->prepare("SELECT COUNT(id) AS count FROM `event` WHERE `status` = 1 and CURRENT_TIMESTAMP > `event_date`");
            $result->execute();
            $total = $result->fetch();
            return $total['count'];
        }

        public static function getTotalCountInCategory($title)
        {
            $total = false;
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id` FROM `category` WHERE `title` = :title and `status` = 1");
            $result->execute(array('title' => $title));
            $string = $result->fetch();
            $id_category = $string['id'];
            $result = $link->prepare("SELECT COUNT(id) AS count FROM `event` WHERE `status` = 1 and `id_category` = :id_category and CURRENT_TIMESTAMP < `event_date`");
            $result->execute(array('id_category' => $id_category));
            $total = $result->fetch();
            return $total['count'];
        }


        public static function getTotalCount()
        {
            $total = false;
            $link = db::getConnection();
            $result = $link->prepare("SELECT COUNT(id) AS count FROM `event` WHERE `status` = 1 and CURRENT_TIMESTAMP < `event_date`");
            $result->execute();
            $total = $result->fetch();
            return $total['count'];
        }

        public static function getArchiveList($page = 1,$count = self::SHOW_BY_DEFAULT)
        {
            $page = intval($page);
            $offset = ($page-1) * $count;
            $link = db::getConnection();
            $result = $link->prepare("SELECT * FROM `event` WHERE CURRENT_TIMESTAMP > `event_date` and `status` = 1 ORDER BY `event_date` DESC LIMIT :LIMIT OFFSET :offset;");
            $result->execute(array('LIMIT' => $count,'offset' => $offset));
            $i=0;
            $archiveList = false;
            while ($row = $result->fetch())
            {
                $archiveList[$i]['id'] = $row['id'];
                $test = $link->prepare("SELECT `title_translit` FROM `category` WHERE `id` = :id");
                $test->execute(array('id' => $row['id_category']));
                $string = $test->fetch();
                $archiveList[$i]['title_category'] = $string['title_translit'];
                $archiveList[$i]['title'] = $row['title'];
                $archiveList[$i]['short_content'] = $row['short_content'];
                $archiveList[$i]['content'] = $row['content'];
                $archiveList[$i]['pub_date'] = $row['pub_date'];
                $archiveList[$i]['event_date'] = $row['event_date'];
                $archiveList[$i]['status'] = $row['status'];
                $i++;
            }
            return $archiveList;
        }

        public static function getEventList($page = 1,$count = self::SHOW_BY_DEFAULT)
        {
            $page = intval($page);
            $offset = ($page-1) * $count;
            $link = db::getConnection();
            $result = $link->prepare("SELECT * FROM `Event` WHERE `status` = 1 and CURRENT_TIMESTAMP < `event_date` ORDER BY `pub_date` DESC LIMIT :LIMIT OFFSET :offset");
            $result->execute(array('LIMIT' => $count,'offset' => $offset));
            $i=0;
            $eventList = false;
            while ($row = $result->fetch())
            {
                $eventList[$i]['id'] = $row['id'];
                $test = $link->prepare("SELECT `title_translit` FROM `category` WHERE `id` = :id");
                $test->execute(array('id' => $row['id_category']));
                $string = $test->fetch();
                $eventList[$i]['title_category'] = $string['title_translit'];
                $eventList[$i]['title'] = $row['title'];
                $eventList[$i]['short_content'] = $row['short_content'];
                $eventList[$i]['content'] = $row['content'];
                $eventList[$i]['pub_date'] = $row['pub_date'];
                $eventList[$i]['event_date'] = $row['event_date'];
                $eventList[$i]['status'] = $row['status'];
                $i++;
            }
            return $eventList;


        }


        public static function getEventListByCategory($title,$page = 1,$count = self::SHOW_BY_DEFAULT)
        {
            $page = intval($page);
            $offset = ($page-1) * $count;
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id` FROM `category` WHERE `title_translit` = :title and `status` = 1");
            $result->execute(array('title' => $title));
            $string = $result->fetch();
            $id_category = $string['id'];
            $result = $link->prepare("SELECT * FROM `event` WHERE `id_category` = :id_category and `status` = 1 and CURRENT_TIMESTAMP < `event_date` ORDER BY `pub_date` DESC LIMIT :LIMIT OFFSET :offset ");
            $result->execute(array('id_category' => $id_category,'LIMIT' => $count,'offset' => $offset ));
            $eventListByCategory = false;
            $i=0;
                while ($row = $result->fetch()) {
                    $eventListByCategory[$i]['id'] = $row['id'];
                    $test = $link->prepare("SELECT `title_translit` FROM `category` WHERE `id` = :id");
                    $test->execute(array('id' => $row['id_category']));
                    $string = $test->fetch();
                    $eventListByCategory[$i]['title_category'] = $string['title_translit'];
                    $eventListByCategory[$i]['title'] = $row['title'];
                    $eventListByCategory[$i]['short_content'] = $row['short_content'];
                    $eventListByCategory[$i]['content'] = $row['content'];
                    $eventListByCategory[$i]['pub_date'] = $row['pub_date'];
                    $eventListByCategory[$i]['event_date'] = $row['event_date'];
                    $eventListByCategory[$i]['status'] = $row['status'];
                    $i++;
                }
                return $eventListByCategory;


        }

        public static function getEventById($title,$id)
        {
            $id = intval($id);
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id` FROM `category` WHERE `title_translit` = :title_translit and `status` = 1");
            $result->execute(array('title_translit' => $title));
            $string = $result->fetch();
            $id_category = $string['id'];
            $result = $link->prepare("SELECT * FROM `event` WHERE `id_category` = :id_category and `id` = :id and `status` = 1;");
            $result->execute(array('id_category' => $id_category, 'id' => $id));
            $eventItem = $result->fetch();
            return $eventItem;
        }

        public static function add($id_category,$title,$short_content,$content,$address,$event_date)
        {
            $link = db::getConnection();
            $result = $link->prepare("INSERT INTO `event`(`id_category`, `title`,`short_content`, `content`, `address`, `event_date`, `status`) VALUES (:id_category,:title,:short_content,:content,:address,:event_date,1)");
            $result->execute(array(
                'id_category' => $id_category,
                'title' => $title,
                'short_content' => $short_content,
                'content' => $content,
                'address' => $address,
                'event_date' => $event_date));
            return $link->lastInsertId();
        }
        public static function update($id_category,$title,$short_content,$content,$address,$event_date,$id)
        {
            $link = db::getConnection();
            $result = $link->prepare("UPDATE `event` SET `id_category` = :id_category , `title` = :title,`short_content` = :short_content, `content` = :content, `address` = :address, `event_date` = :event_date, `status` = 1 WHERE `id` = :id");
            $result->execute(array(
                'id_category' => $id_category,
                'title' => $title,
                'short_content' => $short_content,
                'content' => $content,
                'address' => $address,
                'event_date' => $event_date,
                'id' => $id));
        }

        public static function delete($id)
        {
            $link = db::getConnection();
            $result = $link->prepare("DELETE FROM `event` WHERE `id` = :id");
            $result->execute(array('id' => $id));

        }

        public static function hide($id)
        {
            $link = db::getConnection();
            $result = $link->prepare("SELECT `status` FROM `event` WHERE `id` = :id");
            $result->execute(array('id' => $id));
            $row = $result->fetch();
            $hide = $row['status'];
            if ($hide === 1)$hide = 0;
            else $hide = 1;
            $link = db::getConnection();
            $result = $link->prepare("UPDATE `event` SET `status`=:hide WHERE `id` = :id");
            $result->execute(array('hide' => $hide,'id' => $id));
        }

        public static function validatePost($title,$short_content,$content,$address)
        {
            $error = array();
            if (empty($title) or strlen($title) > 256)
            {
                $error[] = 'Неправильный формат заголовка';
            }
            if (empty($short_content) or $short_content > 256)
            {
                $error[] = 'Неправильньный формат описания';
            }
            if (empty($content))
            {
                $error[] = 'Текст не заполнен';
            }
            if (empty($address) or strlen($address) > 256)
            {
                $error[] = 'Неправильно задан адресс';
            }
            if (empty($error))return true;
            else return $error;
        }


        public static function addUserForEvent($user_id,$news_id)
        {
            $user_id = intval($user_id);
            $news_id = intval($news_id);
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id_users` FROM `event` WHERE `id` = :id_news");
            $result->execute(array('id_news' => $news_id));
            $record = $result->fetch();
            $record = $record['id_users'];
            if (is_string($record))
            {
                $list = array();
                $list = json_decode($record, true);
                $list[] = $user_id;
                $record = json_encode($list);
            }
            else
            {
                $list = array();
                $list[] = $user_id;
                $record = json_encode($list);
            }
            $result = $link->prepare("UPDATE `event` SET `id_users` = :record WHERE `id` = :id_news");
            $result->execute(array('record' => $record,'id_news' => $news_id));
        }

        public static function DeleteEventByUser($user_id,$news_id)
        {
            $user_id = intval($user_id);
            $news_id = intval($news_id);
            $link = db::getConnection();
            $result = $link->prepare("SELECT `id_users` FROM `event` WHERE `id` = :news_id");
            $result->execute(array('news_id' => $news_id));
            $string = $result->fetch();
            $record = $string['id_users'];
            $massive = json_decode($record, true);
            if (is_array($massive) and !empty($massive))
            {
                foreach ($massive as $key => $value) {
                    if ($value == $user_id) {
                        unset($massive[$key]);
                    }
                }
                $record = json_encode($massive);
                $result = $link->prepare("UPDATE `event` SET `id_users` = :record WHERE `id` = :news_id");
                $result->execute(array('record' => $record,'news_id' => $news_id));
                return true;
            }
            return false;
        }
    }