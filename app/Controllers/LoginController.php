<?php

class LoginController implements IController {

    /** @var DatabaseModel $db is for administration of the database */
    private $db;

    public function __construct(){
        require_once(DIRECTORY_MODELS."/MyDatabase.php");
        $this->db = new MyDatabase();
    }

    public function show(string $pageTitle):string{
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;
        $tplData['user'] = [];

        if(isset($_POST['action'])){
            if($_POST['action'] == 'login' && isset($_POST['username']) && isset($_POST['heslo'])){
                $res = $this->db->userLogin($_POST['username'], $_POST['heslo']);
                if($res){
                    #echo "OK: uživatel byl přihlášen";
                }else{
                    #echo "ERROR: Přihlášení uživatele se nezdařilo.";
                }
            }

            else if($_POST['action'] == 'logout'){
                $this->db->userLogout();
                #echo "OK: Uživatel byl odhlášen.";
            }else{
                #echo "WARNING: neznámá akce";
            }
        }

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']) {
            $tplData['user'] = $this->db->getLoggedUserData();
        }

        ob_start();

        require_once(DIRECTORY_VIEWS ."/LoginTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}
?>