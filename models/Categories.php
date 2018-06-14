<?php


class Categories
{
    public static function getCategoriesList()
    {
        $categoriesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title`,`title_translit` FROM `category` WHERE `status` = 1 ORDER BY `order_category`");
        $result->execute();
        $i = 0;
        while ($row = $result->fetch())
        {
            $categoriesList[$i]['title'] = $row['title'];
            $categoriesList[$i]['title_translit'] = $row['title_translit'];
            $i++;
        }
        return $categoriesList;
    }

    private static function getTransliteName($title){
            $char=array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','з'=>'z','и'=>'i',
                'й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t',' '=>'_',
                'у'=>'u','ф'=>'f','х'=>'h',"'"=>'','ы'=>'i','э'=>'e','ж'=>'zh','ц'=>'ts','ч'=>'ch','ш'=>'sh',
                'щ'=>'j','ь'=>'','ю'=>'yu','я'=>'ya','Ж'=>'ZH','Ц'=>'TS','Ч'=>'CH','Ш'=>'SH','Щ'=>'J',
                'Ь'=>'','Ю'=>'YU','Я'=>'YA','ї'=>'i','Ї'=>'Yi','є'=>'ie','Є'=>'Ye','А'=>'A','Б'=>'B','В'=>'V',
                'Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'E','З'=>'Z','И'=>'I','Й'=>'Y','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N',
                'О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'H','Ъ'=>"'",'Ы'=>'I','Э'=>'E');
            $title_translate=strtr($title,$char);
        return $title_translate;
    }

    public static function getAllCategoriesList()
    {
        $categoriesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title`,`title_translit`,`status` FROM `category` ORDER BY `order_category`");
        $result->execute();
        $i = 0;
        while ($row = $result->fetch())
        {
            $categoriesList[$i]['title'] = $row['title'];
            $categoriesList[$i]['title_translit'] = $row['title_translit'];
            $categoriesList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoriesList;
    }

    public static function getAllCategoriesListWithId()
    {
        $categoriesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title`,`id` FROM `category` ORDER BY `order_category`");
        $result->execute();
        $i = 0;
        while ($row = $result->fetch())
        {
            $categoriesList[$i]['id'] = $row['id'];
            $categoriesList[$i]['title'] = $row['title'];
            $i++;
        }
        return $categoriesList;
    }


    public static function checkStatus($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `status` FROM `category` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $cat = $result->fetch();
        $hide = $cat['status'];
        return $hide;
    }


    public static function getCategoryItemByTitle($title)
    {
        $categoriesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT * FROM `category` WHERE `title_translit` = :title");
        $result->execute(array('title' => $title));
        $cat = $result->fetch();
        return $cat;
    }

    public static function getCategoryTitleById($id)
    {
        $categoriesList = array();
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title`,`title_translit` FROM `category` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $categoriesList[] = $result->fetch();
        return $categoriesList;
    }

    public static function getRusCategoryTitleByTitle($title_translit)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `title` FROM `category` WHERE `title_translit` = :title_translit");
        $result->execute(array('title_translit' => $title_translit));
        $title_rus = $result->fetch();
        return $title_rus['title'];
    }

    public static function add($title,$order_category)
    {
        $title_rus = $title;
        $title_translite = self::getTransliteName($title);
        $link = db::getConnection();
        $result = $link->prepare("INSERT INTO `category` (`title`,`title_translit`, `status`, `order_category`) VALUES (:title,:title_translite, 1, :order_category)");
        $result->execute(array('title' => $title_rus,'title_translite' => $title_translite, 'order_category' => $order_category));

    }

    public static function delete($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("DELETE FROM `category` WHERE `id` = :id");
        $result->execute(array('id' => $id));
    }

    public static function update($title,$order_category,$id)
    {
        $title_rus = $title;
        $title_translite = self::getTransliteName($title);
        $link = db::getConnection();
        $result = $link->prepare("UPDATE `category` SET `title`=:title,`title_translit` = :title_translite,`order_category`=:order_category WHERE `id` = :id");
        $result->execute(array('title' => $title_rus,'title_translite' => $title_translite,'order_category' => $order_category, 'id' => $id));
    }

    public static function hide($id)
    {
        $hide = self::checkStatus($id);
        if ($hide === 1)$hide = 0;
        else $hide = 1;
        $link = db::getConnection();
        $result = $link->prepare("UPDATE `category` SET `status`=:hide WHERE `id` = :id");
        $result->execute(array('hide' => $hide,'id' => $id));
        $result = $link->prepare("UPDATE `event` SET `status`=:hide WHERE `id_category` = :id");
        $result->execute(array('hide' => $hide,'id' => $id));
    }

}