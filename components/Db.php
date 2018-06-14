<?php

class db
{
    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_config.php';
        $params = include($paramsPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['db_name']};charset={$params['charset']}";
        $link = new PDO($dsn,$params['user'],$params['password'],$params['option']);
        return $link;
        }
}
