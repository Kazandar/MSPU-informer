<?php


class UserController
{
    private $id_user = false;
    private $mail = false;
    private $pass = false;
    private $pass2 = false;
    private $name = false;
    private $patronymic = false;
    private $surname = false;
    private $error = array();
    private $remember = false;


    public function actionRegister()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $session_exist = false;
        if (isset($_SESSION['user']))
        {
            $session_exist = true;
        }
        if (isset($_POST['register']))
        {
            $this->name = htmlspecialchars($_POST['name']);
            $this->patronymic = htmlspecialchars($_POST['patronymic']);
            $this->surname = htmlspecialchars($_POST['surname']);
            $this->mail = htmlspecialchars($_POST['mail']);
            $this->pass = htmlspecialchars($_POST['pass']);
            $this->pass2 = htmlspecialchars($_POST['pass2']);
            $this->error = User::validation($this->mail,$this->pass,$this->pass2);
            if ($this->error === true)
            {
                $this->error = User::registration($this->name,$this->surname,$this->patronymic,$this->mail,$this->pass);
                if(!is_array($this->error))
                    {
                        header('Location:/login');
                    }
            }

        }

        include_once ROOT . '/views/site/reg_form.php';
    }

    public function actionLogin()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $session_exist = false;
        if (isset($_SESSION['user']))
        {
            $session_exist = true;
        }
        if (isset($_POST['register']))
        {
            header('Location:/register');
        }
        if (isset($_POST['cancel']))
        {
            header('Location:/');
        }
        if (isset($_POST['login']))
        {
             if (empty(trim($_POST['mail'],'')))
        {
            $this->error[] = 'Поле логин не может быть пустым';

        }
             if (empty(trim($_POST['pass'],'')))
        {
            $this->error[] = 'Поле пароль не может быть пустым';
        }

            $this->mail = htmlspecialchars($_POST['mail']);
            $this->pass = htmlspecialchars($_POST['pass']);
            if (isset($_POST['remember']))
            $this->remember = htmlspecialchars($_POST['remember']);
            else $this->remember = false;
            $this->id_user = User::authentication($this->pass,$this->mail);

            if ($this->id_user)
            {
                $_SESSION['user'] = $this->id_user;
                $_SESSION['role'] = User::getRole($this->id_user);
                $_SESSION['mail'] = User::getUserById($this->id_user);
                $_SESSION['name'] = User::getName($this->id_user);
                $_SESSION['surname'] = User::getSurname($this->id_user);
                $_SESSION['patronymic'] = User::getPatronymic($this->id_user);

                if ($this->remember === 'selected')
                {
                   setcookie('login',$this->mail);
                   setcookie('pass',$this->pass);
                }
                else{
                   setcookie("login", "0", time() - 1, "/");
                   setcookie("pass", "0", time() - 1, "/");
                }
                header('Location:/cabinet');
            }
            else
            {
                $this->error[] = 'Неправильный логин или пароль';
            }

        }
        include_once ROOT . '/views/site/login_form.php';
    }

    public function actionLogout()
    {
        session_destroy();
        header('Location:/');
    }

    public function actionDeleteAccount()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        $this->id_user = User::checkLogged();
        if (isset($_POST['yes']))
        {
            $pass = $_POST['pass'];
            if (!empty($this->id_user))
            {
                $ver = User::authentication($pass,$_SESSION['mail']);
                if($ver !== false)
                {
                    User::deleteAccount($this->id_user);
                    $this->actionLogout();
                }
            }
                if($ver === false) $this->error[] = 'Пароль введен неверно, попробуйте еще раз';

        }
        if (isset($_POST['no']))
        {
            header('Location:/cabinet');
            exit;
        }

        include_once ROOT . '/views/cabinet/delete.php';
    }


}