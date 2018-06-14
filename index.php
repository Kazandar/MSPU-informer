<?php
    // Front-controller


    // 1.Settings

    ini_set('display_errors',1);
    error_reporting(E_ALL);


    // 2. Include components

    DEFINE('ROOT',dirname(__FILE__));
    require_once ROOT.'/components/autoload.php';


    // 3. Start session
    session_start();

    // 4. Use Router

    $router = new Router();
    $router->run();












