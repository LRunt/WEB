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

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']){
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
        }

        if(isset($_POST['action']) and $_POST['action'] == "delete"
            and isset($_POST['id_user'])
        ){
            // provedu smazani uzivatele
            $ok = $this->db->deleteUser(intval($_POST['id_user']));
            if($ok){
                $tplData['success'] = "OK";
                $tplData['delete'] = "Uživatel s ID:$_POST[id_user] byl smazán z databáze.";
            } else {
                $tplData['success'] = "ERROR";
                $tplData['delete'] = "Uživatele s ID:$_POST[id_user] se nepodařilo smazat z databáze.";
            }
        }else if(isset($_POST['pravo'])){
            $user = $this->db->getUser($_POST['id_user']);
            //var_dump($user);
            $update = $this->db->updateUser($_POST["id_user"],$user[0]["username"], $user[0]["heslo"], $user[0]["email"], $_POST["pravo"]);
            if($update){
                $tplData['success'] = "OK";
                $tplData['delete'] = "Uživateli s ID:$_POST[id_user] se podařilo změnit právo.";
            }else{
                $tplData['success'] = "ERROR";
                $tplData['delete'] = "Uživateli s ID:$_POST[id_user] se nepodařilo změnit právo.";
            }
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

        //// nactu aktulani data uzivatelu
        $tplData['users'] = $this->db->getAllUsers();
        $tplData['rights'] = $this->db->getAllRights();

        ob_start();

        require_once(DIRECTORY_VIEWS ."/UserManagementTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}

?>