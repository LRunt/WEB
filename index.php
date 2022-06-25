<?php

    //nasteni vlastniho nasteveni webu
    require_once("settings.inc.php");

    require_once("app/ApplicationStart.php");

    $app = new ApplicationStart();
    $app->appstart();

?>
