<?php
    return array(
        'host' => 'localhost',
        'db_name' => 'math',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'option' => array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                          PDO::ATTR_EMULATE_PREPARES => false));

