<?php
class SiteController
{
    public function actionIndex()
    {
        $eventsListForIndex = array();
        $eventsListForIndex = Events::getEventList();
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        include_once ROOT.'/views/site/index.php';
    }

    public function actionAbout()
    {
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        include_once ROOT . '/views/site/about.php';
    }

    public function actionFeedback()
    {
        if (isset($_POST['feedback']))
        {
            $result = User::Mail();
        }
        $categoriesList = array();
        $categoriesList = Categories::getCategoriesList();
        include_once ROOT . '/views/site/feedback.php';
    }


}