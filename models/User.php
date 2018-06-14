<?php


class User
{
    public static function Mail()
    {
        $to = 'Roxed128500@mail.ru';
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        if(isset($_POST['theme']) and !empty($_POST['theme']))
        {
            $theme = $_POST['theme'];
        }
        else
        {
            $theme = 'Сообщение от пользователя сайта mathfaculty-mpgu.com';
        }
        if(isset($_POST['message']) and !empty($_POST['message']))
        {
            $message = $_POST['message'];
        }
        else
        {
            $message = 'Пустое сообщение';
        }

        $message = "{$message} . От . {$name}";

            if(filter_var($mail,FILTER_VALIDATE_EMAIL))
            {
                $result = mail($to,$theme,$message);
                if ($result) return $result = true;
            }

            return false;
    }

    public static function changeRole($id_role, $id_user)
    {
        $link = db::getConnection();
        $result = $link->prepare("UPDATE `user` SET `id_role`=:id_role WHERE `id` = :id_user");
        $result->execute(array('id_role' => $id_role, 'id_user' => $id_user));
    }

    public static function getRolesList()
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id`,`title` FROM `role`");
        $result->execute(array());
        $roles_list = false;
        $i = 0;
        while ($row = $result->fetch()) {
            $roles_list[$i]['id'] = $row['id'];
            $roles_list[$i]['title'] = $row['title'];
            $i++;
        }
        return $roles_list;
    }

    public static function BlockUserById($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id_role` FROM `user` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $row = $result->fetch();
        $role_status = $row['id_role'];
        if ($role_status === 1) {
            $role_status = 2;
        } else {
            $role_status = 1;
        }
        $result = $link->prepare("UPDATE `user` SET `id_role` = :role_status WHERE `id` = :id");
        $result->execute(array('role_status' => $role_status, 'id' => $id));
    }

    public static function getRoleTitleById($id)
    {
        $rolesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title` FROM `role` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $role_title = $result->fetch();
        return $role_title['title'];
    }

    public static function getName($id_user)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `name` FROM `user` WHERE `id` = :id_user");
        $result->execute(array('id_user' => $id_user));
        $result = $result->fetch();
        $name = $result['name'];
        return $name;
    }

    public static function getSurname($id_user)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `surname` FROM `user` WHERE `id` = :id_user");
        $result->execute(array('id_user' => $id_user));
        $result = $result->fetch();
        $surname = $result['surname'];
        return $surname;
    }

    public static function getPatronymic($id_user)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `patronymic` FROM `user` WHERE `id` = :id_user");
        $result->execute(array('id_user' => $id_user));
        $result = $result->fetch();
        $patronymic = $result['patronymic'];
        return $patronymic;
    }

    public static function getRole($id_user)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id_role` FROM `user` WHERE `id` = :id_user");
        $result->execute(array('id_user' => $id_user));
        $result = $result->fetch();
        $role = $result['id_role'];
        return $role;
    }


    public static function searchMail($mail_search)
    {
        $info = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id`,`id_role`,`mail`,`name`,`surname`,`patronymic` FROM `user` WHERE `mail` = :mail_search");
        $result->execute(array('mail_search' => $mail_search));
        $result = $result->fetch();
        if (!empty($result))
        {
            $info[0]['id'] = $result['id'];
            $info[0]['mail'] = $result['mail'];
            $info[0]['id_role'] = $result['id_role'];
            $info[0]['name'] = $result['name'];
            $info[0]['surname'] = $result['surname'];
            $info[0]['patronymic'] = $result['patronymic'];
            return $info;
        }

        return false;
    }

    public static function getAllUser()
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id`,`id_role`,`mail`,`name`,`surname`,`patronymic` FROM `user`");
        $result->execute(array());
        $i = 0;
        $info = false;
        while ($row = $result->fetch()) {
            $info[$i]['id'] = $row['id'];
            $info[$i]['id_role'] = $row['id_role'];
            $info[$i]['mail'] = $row['mail'];
            $info[$i]['name'] = $row['name'];
            $info[$i]['surname'] = $row['surname'];
            $info[$i]['patronymic'] = $row['patronymic'];
            $i++;
        }
        return $info;
    }

    public static function DeleteEventByUser($user_id, $news_id)
    {
        $user_id = intval($user_id);
        $news_id = intval($news_id);
        $link = db::getConnection();
        $result = $link->prepare("SELECT `events` FROM `user` WHERE `id` = :user_id");
        $result->execute(array('user_id' => $user_id));
        $string = $result->fetch();
        $record = $string['events'];
        $massive = json_decode($record, true);
        if (is_array($massive) and !empty($massive)) {
            foreach ($massive as $key => $value) {
                if ($value == $news_id) {
                    unset($massive[$key]);
                }
            }
            $record = json_encode($massive);
            $result = $link->prepare("UPDATE `user` SET `events` = :record WHERE `id` = :user_id");
            $result->execute(array('record' => $record, 'user_id' => $user_id));
            return true;
        }
        return false;
    }

    public static function CheckEvent($user_id, $news_id)
    {
        $user_id = intval($user_id);
        $news_id = intval($news_id);
        $link = db::getConnection();
        $result = $link->prepare("SELECT `events` FROM `user` WHERE `id` = :user_id");
        $result->execute(array('user_id' => $user_id));
        $string = $result->fetch();
        $record = $string['events'];
        $massive = json_decode($record);
        if (!empty($massive))
        {
            foreach ($massive as $value) {
                if ($value === $news_id) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function addEvent($user_id,$news_id)
    {
        $user_id = intval($user_id);
        $news_id = intval($news_id);
        $link = db::getConnection();
        $result = $link->prepare("SELECT `events` FROM `user` WHERE `id` = :user_id");
        $result->execute(array('user_id' => $user_id));
        $record = $result->fetch();
        $record = $record['events'];
        if (is_string($record)) {
            $list = array();
            $list = json_decode($record, true);
            $list[] = $news_id;
            $record = json_encode($list);
        } else {
            $list = array();
            $list[] = $news_id;
            $record = json_encode($list);
        }
        $result = $link->prepare("UPDATE `user` SET `events` = :record WHERE `id` = :user_id");
        $result->execute(array('record' => $record, 'user_id' => $user_id));
    }

    public static function getUserListForEvent($event_id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id_users` FROM `event` WHERE `id` = :event_id;");
        $result->execute(array('event_id' => $event_id));
        $row = $result->fetch();
        $record = $row['id_users'];
        if (is_string($record) and !empty($record))
        {
            $massive = json_decode($record);
            $i = 0;
            while ($i < count($massive))
            {
                $id_user = $massive[$i];
                $link = db::getConnection();
                $result = $link->prepare("SELECT `id`,`id_role`,`mail`,`name`,`surname`,`patronymic` FROM `user` WHERE `id` = :id_user;");
                $result->execute(array('id_user' => $id_user));
                $user[] = $result->fetch();
                $i++;
            }
            return $user;
        }
        return false;
    }

    public static function getEventListForUser($user_id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `events` FROM `user` WHERE `id` = :user_id;");
        $result->execute(array('user_id' => $user_id));
        $record = $result->fetch();
        $record = $record['events'];
        $event_list = array();
        if (is_string($record) and !empty($record))
        {
            $massive = json_decode($record);
            $i = 0;
            foreach ($massive as $id_news)
            {
                $id_news = intval($id_news);
                $result = $link->prepare("SELECT * FROM `event` WHERE `id` = :id_news and CURRENT_TIMESTAMP < `event_date` and `status` = 1");
                $result->execute(array('id_news' => $id_news));
                while ($row = $result->fetch())
                {
                    $event_list[$i]['id'] = $row['id'];
                    $test = $link->prepare("SELECT `title_translit` FROM `category` WHERE `id` = :id");
                    $test->execute(array('id' => $row['id_category']));
                    $string = $test->fetch();
                    $event_list[$i]['title_category'] = $string['title_translit'];
                    $event_list[$i]['title'] = $row['title'];
                    $event_list[$i]['short_content'] = $row['short_content'];
                    $i++;
                }
            }
        }
        return $event_list;
    }


    public static function deleteAccount($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("DELETE FROM `user` WHERE `id` = :id;");
        $result->execute(array('id' => $id));
    }

    public static function edit($new_name,$new_surname,$new_patronymic,$new_mail,$new_pass,$id,$old_pass,$old_mail)
    {
        $name = $new_name;
        $surname = $new_surname;
        $patronymic = $new_patronymic;
        $mail = $new_mail;
        $pass = $new_pass;

        $link = db::getConnection();


        if (empty($mail))
        {
            $mail = $old_mail;
        }

        if (empty($pass))
        {
            $pass = $old_pass;
        }
        $pass = password_hash($pass,PASSWORD_DEFAULT);
        $result = $link->prepare("UPDATE `user` SET `name` = :name,`surname` = :surname,`patronymic` = :patronymic,`mail` = :mail,`pass`= :pass WHERE `id` = :id");
        $result->execute(array('name' => $name,'surname' => $surname,'patronymic' => $patronymic,'mail' => $mail,'pass' => $pass,'id' => $id));
    }

    public static function getUserById($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `mail` FROM `user` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $user = $result->fetch();
        return $user['mail'];
    }

    public static function checkLogged()
    {
       return $_SESSION['user'] ?? header('Location:/login');
    }

    public static function authentication($pass,$mail = null)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id`,`pass` FROM `user` WHERE `mail` = :mail");
        $result->execute(array('mail' => $mail));
        $result = $result->fetch();
        $id_user = $result['id'];
        $result = $result['pass'];
        if (password_verify($pass,$result))
            return $id_user;
        else
            return false;

    }


    public static function validation($mail,$pass,$pass2)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT 1 FROM `user` WHERE `mail` = :mail LIMIT 1");
        $result->execute(array('mail' => $mail));
        $result = $result->fetch();
        $result = $result['1'];
        $error = array();
        if ($result === 1)
        {
            $error[] = 'Пользователь с таким логином уже существует';
        }
        if (strlen(trim($mail,'')) > 0)
        {
            if (!(filter_var($mail,FILTER_VALIDATE_EMAIL)))
            {
                $error[] = 'Адрес указан не корректно';
            }
        }
        if (strlen(trim($pass,'')) > 0)
        {
            if (!(preg_match('~^(\w){8,16}$~', $pass)))
            {
                $error[] = 'Пароль должен быть от 8 до 16 символов(Латиница и цифры)';
            }
        }
        if (strlen(trim($pass,'')) > 0)
        {
            if ($pass !== $pass2) {
                $error[] = 'Пароли не совпадают';
            }
        }

        if(!$error)
            return $error = true;
        else
            return $error;
    }


    public static function registration($name,$surname,$patronymic,$mail,$pass)
    {
        $link = db::getConnection();
        $pass = password_hash($pass,PASSWORD_DEFAULT);
        $result = $link->prepare("INSERT INTO `user`(`name`,`patronymic`,`surname`,`mail`, `pass`,`id_role`) VALUES (:name,:patronymic,:surname,:mail,:pass,2)");
        $result->execute(array('name' => $name,'surname' => $surname,'patronymic' => $patronymic,'mail' => $mail,'pass' => $pass));
        if($result)
            return true;
        else
            return $error[] = 'Регистрация не удалась';

    }

}