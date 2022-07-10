<?php

require_once(DIRECTORY_CONTROLLERS."/IController.php");

class MenuController implements IController{

    private $db;

    public function __construct(){
        require_once (DIRECTORY_MODELS."/MyDatabase.php");
        $this->db = new MyDatabase();
    }

    public function show(string $pageTitle):string{

        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']){
            $tplData['user'] = $this->db->getLoggedUserData();
        }

        $tplData['food'] = $this->db->getAllProducts();

        ob_start();

        require_once(DIRECTORY_VIEWS ."/MenuTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>