<?php


class Admin
{
    public static function isAdmin($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `admin` FROM `user` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $status = $result->fetch();
        $status = $status['admin'];
        if ($status === 1)
        {
            return true;
        }
        else
            return false;
    }

    public static function getImage($id)
    {
        if(file_exists(ROOT."/upload/images/events/$id.jpg"))
        {
            $path = "/upload/images/events/$id.jpg";
            return $path;
        }

        else
            return false;
    }

    public static function checkStatus($id)
    {
        $link = db::getConnection();
        $result = $link->prepare("SELECT `id_role` FROM `user` WHERE `id` = :id");
        $result->execute(array('id' => $id));
        $status = $result->fetch();
        $status = $status['id_role'];
        return $status;
    }

}