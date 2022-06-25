<?php

class IntroductionController implements IController{

    /** @var DatabaseModel $db is for administration of the database */
    private $db;

    /**
     * Initialization of the connection to the database
     */
    public function __construct(){
        require_once(DIRECTORY_MODELS."/MyDatabase.php");
        $this->db = new MyDatabase();
    }

    public function show(string $pageTitle):string{
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['rights'] = $this->db->getAllRights();

        ob_start();

        require_once(DIRECTORY_VIEWS ."/IntroductionTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}

?>