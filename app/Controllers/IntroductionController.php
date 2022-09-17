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

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']){
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
        }

        if(isset($_POST['action'])){
            if($_POST['action'] == 'logout'){
                $this->db->userLogout();
                header("Refresh:0");
                #echo "OK: Uživatel byl odhlášen.";
            }else{
                #echo "WARNING: neznámá akce";
            }
        }

        ob_start();

        require_once(DIRECTORY_VIEWS ."/IntroductionTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}

?>