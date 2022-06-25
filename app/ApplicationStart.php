<?php

class ApplicationStart{

    /**
     * Initialization of web application
     */
    public function __construct(){
        require_once(DIRECTORY_CONTROLLERS."/IController.php");
    }

    public function appStart(){
        if(isset($_GET["page"]) && array_key_exists($_GET['page'], WEB_PAGES)){
            $pageKey = $_GET["page"];
        } else{
            $pageKey = DEFAULT_WEB_PAGE_KEY;
        }

        $pageInfo = WEB_PAGES[$pageKey];

        require_once(DIRECTORY_CONTROLLERS."/".$pageInfo["file_name"]);

        $controller = new $pageInfo["class_name"];

        echo $controller->show($pageInfo["title"]);
    }

}

?>