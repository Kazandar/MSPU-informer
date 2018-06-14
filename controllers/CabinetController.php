<?php

class CabinetController
{
    private $id_user = false;
    private $mail_user = false;
    private $error = array();

    private function actionChecker()
    {
        $this->id_user = User::checkLogged();
        $this->mail_user = User::getUserById($this->id_user);
        return $this->mail_user;
    }

    public function actionIndex()
    {
        if (isset($_POST['statistic'])) {
            header('Location:/admin/statistics');
        }
        if (isset($_POST['admin_panel'])) {
            header('Location:/admin');
        }
        if (isset($_POST['my_events'])) {
            header('Location:/cabinet/my_events');
        }
        if (isset($_POST['edit'])) {
            header('Location:/cabinet/edit');
        }
        if (isset($_POST['logout'])) {
            header('Location:/logout');
        }
        if (isset($_POST['delete'])) {
            header('Location:/cabinet/delete');
        }
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $this->actionChecker();
        $status = Admin::checkStatus($_SESSION['user']);
        include_once ROOT . '/views/cabinet/index.php';
    }

    public function actionEdit()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $old_mail = $this->actionChecker();

        if (isset($_POST['edit'])) {
            $new_name = htmlspecialchars($_POST['name']);
            $new_surname = htmlspecialchars($_POST['surname']);
            $new_patronymic = htmlspecialchars($_POST['patronymic']);
            $mail_new = htmlspecialchars($_POST['new_mail']);
            $old_pass = htmlspecialchars($_POST['old_pass']);
            $new_pass1 = htmlspecialchars($_POST['new_pass1']);
            $new_pass2 = htmlspecialchars($_POST['new_pass2']);
            $this->id_user = User::authentication($old_pass, $old_mail);
            if ($this->id_user !== false) {
                $this->error = User::validation($mail_new, $new_pass1, $new_pass2);
                if (!is_array($this->error)) {
                    User::edit($new_name, $new_surname, $new_patronymic, $mail_new, $new_pass1, $this->id_user,
                        $old_pass, $old_mail);
                    $_SESSION['user'] = $this->id_user;
                    $_SESSION['mail'] = User::getUserById($this->id_user);
                    $_SESSION['name'] = User::getName($this->id_user);
                    $_SESSION['surname'] = User::getSurname($this->id_user);
                    $_SESSION['patronymic'] = User::getPatronymic($this->id_user);
                    header('Location:/cabinet');
                    exit;
                }
            } else {
                $this->error[] = 'Старый пароль не верен';
            }

        }
        if (isset($_POST['cancel'])) {
            header('Location:/cabinet');
            exit;
        }

        include_once ROOT . '/views/cabinet/edit.php';
    }

    public function actionMyEvents($page = 1)
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $this->id_user = User::checkLogged();
        $list = array();
        $list = User::getEventListForUser($this->id_user);
        include_once ROOT . '/views/cabinet/list.php';
    }
}