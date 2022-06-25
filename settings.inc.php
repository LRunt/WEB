<?php
    //basic web settings

    //settings of web database
    define("DB_SERVER","localhost");
    define("DB_NAME", "sp_kiv_web");
    define("DB_USER", "root");
    define("DB_PASS", "");

    //names of tables in database
    define("TABLE_UZIVATEL", "lrunt_uzivatel");
    define("TABLE_PRAVO", "lrunt_pravo");
    define("TABLE_RECENZE", "lrunt_recenze");
    define("TABLE_PRODUKT", "lrunt_produkt");


    //all websites of web
    /** Adresar kontroleru. */
    const DIRECTORY_CONTROLLERS = "app\Controllers";
    /** Adresar modelu. */
    const DIRECTORY_MODELS = "app\Models";
    /** Adresar sablon */
    const DIRECTORY_VIEWS = "app\Views";

    /** Klic defaultni webove stranky. */
    const DEFAULT_WEB_PAGE_KEY = "uvod";

    const WEB_PAGES = array(
        "uvod" => array(
            "title" => "Úvodní stránka",

            "file_name" => "IntroductionController.php",
            "class_name" => "IntroductionController",
        ),
        "sprava" => array(
            "title" => "Správa uživatelů",

            "file_name" => "UserManagementController.php",
            "class_name" => "UserManagementController",
        ),
    );

?>