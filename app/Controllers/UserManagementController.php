<?php

require_once(DIRECTORY_CONTROLLERS."/IController.php");

class UserManagementController implements IController {

    private $db;

    public function __construct(){
        require_once (DIRECTORY_MODELS."/MyDatabase.php");
        $this->db = new MyDatabase();
    }

    public function show(string $pageTitle):string{

        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        if(isset($_POST['action']) and $_POST['action'] == "delete"
            and isset($_POST['id_user'])
        ){
            // provedu smazani uzivatele
            $ok = $this->db->deleteUser(intval($_POST['id_user']));
            if($ok){
                $tplData['delete'] = "OK: Uživatel s ID:$_POST[id_user] byl smazán z databáze.";
            } else {
                $tplData['delete'] = "CHYBA: Uživatele s ID:$_POST[id_user] se nepodařilo smazat z databáze.";
            }
        }

        //// nactu aktulani data uzivatelu
        $tplData['users'] = $this->db->getAllUsers();

        ob_start();

        require_once(DIRECTORY_VIEWS ."/UserManagementTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}

?>