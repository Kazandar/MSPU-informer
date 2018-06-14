<?php


class AdminController
{
    private $error = array();

    private function actionCheckStatus()
    {
        $id_user = User::checkLogged();
        $status = Admin::checkStatus($id_user);
        return $status;
    }

    public function actionIndex()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        isset($_POST['manage_events']) ? header('Location:/admin/manage_events'):false;
        isset($_POST['manage_categories']) ? header('Location:/admin/manage_categories'):false;
        isset($_POST['manage_users']) ? header('Location:/admin/manage_users'):false;
        isset($_POST['statistics']) ? header('Location:/admin/statistics'):false;
        include_once ROOT . '/views/admin/index.php';
    }

    public function actionManageCategories()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $cat_list = array();
        $cat_list = Categories::getAllCategoriesList();
        if (isset($_POST['back']))header('Location:/admin');
        include_once ROOT . '/views/admin/category/index.php';
    }
    public function actionManageEvents()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $event_list = Events::getEventListForAdmin();

        if (isset($_POST['back']))header('Location:/admin');
        include_once ROOT . '/views/admin/event/index.php';
    }

    public function actionManageUsers()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $info = User::getAllUser();
        foreach ($info as $role)
        {
            $id_role =  $role['id_role'];
            $role_title_list[] = User::getRoleTitleById($id_role);
        }
        if (isset($_POST['search']))
        {
            unset($info);
            $info = User::searchMail(trim(htmlspecialchars($_POST['mail_search']),''));
        }
        if (isset($_POST['back']))
        {
            header('Location:/admin');
        }
        include_once ROOT . '/views/admin/user/index.php';
    }

    public function actionAddCategories()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        isset($_POST['back'])?header('Location:/admin/manage_categories'):false;
        if (isset($_POST['add']))
        {
            $title = htmlspecialchars($_POST['title']);
            $order_category = htmlspecialchars($_POST['order_category']);
            if (preg_match('~[а-яА-я]+~',$title))
            {
                    Categories::add($title, $order_category);
                    header('Location:/admin/manage_categories');
            }
            else $this->error[] = 'Некорректно введено название';
        }
        include_once ROOT . '/views/admin/category/create.php';
    }

    public function actionAddEvent()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $category_list = Categories::getAllCategoriesListWithId();
        $error = false;
        if (isset($_POST['add']))
        {
            $id_category = htmlspecialchars($_POST['category']);
            $title = htmlspecialchars($_POST['title']);
            $short_content = htmlspecialchars($_POST['short_content']);
            $content = htmlspecialchars($_POST['content']);
            $address = htmlspecialchars($_POST['address']);
            $event_date = htmlspecialchars($_POST['date']);
            $error = Events::validatePost($title,$short_content,$content,$address);
            if ($error)
            {
                $event_id = Events::add($id_category, $title, $short_content, $content, $address, $event_date);
                if ($event_id)
                {
                    if (is_uploaded_file($_FILES["review"]["tmp_name"]))
                    {
                        move_uploaded_file($_FILES["review"]["tmp_name"],
                            $_SERVER['DOCUMENT_ROOT'] . "/upload/images/events/{$event_id}.jpg");
                    }
                    header('Location:/admin/manage_events');
                    exit;
                }
            }
        }
        if (isset($_POST['back']))
        {
            header('Location:/admin/manage_events');
            exit;
        }
        include_once ROOT . '/views/admin/event/create.php';
    }

    public function actionDeleteCategory($title)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $cat = Categories::getCategoryItemByTitle($title);
        $cat_id = $cat['id'];
        $title_rus = $cat['title'];
        if (isset($_POST['back']))header('Location:/admin/manage_categories');
        if (isset($_POST['yes']))
        {
                Categories::delete($cat_id);
                header('Location:/admin/manage_categories');
        }

        include_once ROOT . '/views/admin/category/delete.php';
    }

    public function actionDeleteEvent($id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        if (isset($_POST['back']))header('Location:/admin');
        if (isset($_POST['yes']))
        {
            Events::delete($id);
            header('Location:/admin/manage_events');
        }
        if (isset($_POST['cancel']))
        {
            header('Location:/admin/manage_events');
        }
        include_once ROOT . '/views/admin/event/delete.php';
    }

    public function actionUpdateCategory($title)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $cat = Categories::getCategoryItemByTitle($title);
        $title_rus = $cat['title'];
        $cat_id = $cat['id'];
        $order_category = $cat['order_category'];
        isset($_POST['back'])?header('Location:/admin/manage_categories'):false;
        if (isset($_POST['change']))
        {
            $title = htmlspecialchars($_POST['title']);
            $order_category = htmlspecialchars($_POST['order_category']);
            if (preg_match('~[а-яА-Я]+~',$title))
            {
                Categories::update($title, $order_category, $cat_id);
                header('Location:/admin/manage_categories');
            }
            else $this->error[] = 'Некорректно введено название';
        }
        if (isset($_POST['cancel']))
        {
            header('Location:/admin/manage_categories');
        }
        include_once ROOT . '/views/admin/category/update.php';
    }

    public function actionUpdateEvent($id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $error = false;
        $data = Events::getEventByIdForAdmin($id);
        $category_list = Categories::getAllCategoriesListWithId();
        $img = Admin::getImage($id);
        if ($img === false) $img = "/upload/images/events/no-image.jpg";
        if (isset($_POST['add']))
        {
            $id_category = htmlspecialchars($_POST['category']);
            $title = htmlspecialchars($_POST['title']);
            $short_content = htmlspecialchars($_POST['short_content']);
            $content = htmlspecialchars($_POST['content']);
            $address = htmlspecialchars($_POST['address']);
            $event_date = htmlspecialchars($_POST['date']);
            $error = Events::validatePost($title,$short_content,$content,$address);
            if ($error)
            {
                Events::update($id_category, $title, $short_content, $content, $address, $event_date,$id);
                if ($id)
                {
                    if (is_uploaded_file($_FILES["review"]["tmp_name"]))
                    {
                        move_uploaded_file($_FILES["review"]["tmp_name"],
                            $_SERVER['DOCUMENT_ROOT'] . "/upload/images/events/{$id}.jpg");
                    }
                    header('Location:/admin/manage_events');
                    exit;
                }
            }
        }
        if (isset($_POST['back']))
        {
            header('Location:/admin/manage_events');
            exit;
        }
        include_once ROOT . '/views/admin/event/update.php';
    }


    public function actionHideCategory($title)
    {
        $status = $this->actionCheckStatus();
        $cat = Categories::getCategoryItemByTitle($title);
        $cat_id = $cat['id'];
        Categories::hide($cat_id);
        header('Location:/admin/manage_categories');

    }

    public function actionHideEvent($id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        Events::hide($id);
        header('Location:/admin/manage_events');

    }

    public function actionBlockUser($user_id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        User::BlockUserById($user_id);
        header('Location:/admin/manage_users');
    }

    public function actionRoleUser($user_id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $mail = User::getUserById($user_id);
        $role_list = User::getRolesList();
        unset($role_list[0]);
        if (isset($_POST['yes']))
        {
            $id_role = htmlspecialchars($_POST['role']);
            User::changeRole($id_role,$user_id);
            header('Location:/admin/manage_users');
        }
        if (isset($_POST['back']))
            header('Location:/admin/manage_users');
        include_once ROOT.'/views/admin/user/update.php';

    }

    public function actionStatistics()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $event_list = Events::getEventListForAdmin();
        foreach ($event_list as $user)
        {
            $elements = json_decode($user['id_users']);
            $count[] = count($elements);
        }

        if (isset($_POST['back']))
        {
            header('Location:/admin');
        }

        include_once ROOT.'/views/admin/statistics/index.php';
    }

    public function actionUserList($event_id)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $status = $this->actionCheckStatus();
        $user_list = User::getUserListForEvent($event_id);
        $event = Events::getEventByIdForAdmin($event_id);
        if (is_array($user_list) and !empty($user_list))
        {
            foreach ($user_list as $role)
            {
                $id_role = $role['id_role'];
                $role_title_list[] = User::getRoleTitleById($id_role);
            }
        }
        if (isset($_POST['back']))
        {
            header('Location:/admin/statistics');
        }
        else
        {
            $this->error[0] = 'Никто не регистрировался на данное мероприятие';
        }

        include_once ROOT. '/views/admin/statistics/user_list.php';
    }

}