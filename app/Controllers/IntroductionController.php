<?php

class IntroductionController implements IControler{

    /** @var DatabaseModel $db is for administration of the database */
    private $db;

    /**
     * Initialization of the connection to the database
     */
    public function __construct(){

    }

    public function show(string $pageTitle):string{

        ob_start();

        return "null";
    }
}

?>