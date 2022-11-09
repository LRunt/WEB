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

        if(isset($_POST['action']) and $_POST['action'] == "delete" and isset($_POST['id_user'])){
            if($tplData['user'][0] == $_POST['id_user']) {
                $tplData['success'] = "WARNING";
                $tplData['delete'] = "Uživatel nesmí smazat sám sebe";
            }else if($tplData['user'][1] == 2 && ($this->db->getUserRole($_POST['id_user']) == "Admin" || $this->db->getUserRole($_POST['id_user']) == "Super Admin")){ //test práva
                $tplData['success'] = "WARNING";
                $tplData['delete'] = "Adminstrátorské účty může mazat jenom Super Admin.";
            }else if($this->db->haveUserReview($_POST['id_user'])){
                $tplData['success'] = "WARNING";
                $tplData['delete'] = "Uživatel s ID:$_POST[id_user] nelze smazat, jelikož zveřejnil recenze.<br>Pokud chcete uživatele smazat, budete muset nejdříve smazat jeho recenze.";
            }else{
                // provedu smazani uzivatele
                $ok = $this->db->deleteUser(intval($_POST['id_user']));
                if($ok){
                    $tplData['success'] = "OK";
                    $tplData['delete'] = "Uživatel s ID:$_POST[id_user] byl smazán z databáze.";
                } else {
                    $tplData['success'] = "ERROR";
                    $tplData['delete'] = "Uživatele s ID:$_POST[id_user] se nepodařilo smazat z databáze.";
                }
            }
        }else if(isset($_POST['pravo'])){
            if($tplData['user'][0] == $_POST['id_user']){
                $tplData['success'] = "WARNING";
                $tplData['delete'] = "Uživatel nesmí měnit právo sám sobě.";
            }else if($tplData['user'][1] == 2 && ($this->db->getUserRights($_POST['id_user']) == "Admin" || $this->db->getUserRights($_POST['id_user']) == "Super Admin" || $_POST["pravo"] == "1" || $_POST["pravo"] == "2")) {
                $tplData['success'] = "WARNING";
                $tplData['delete'] = "Admin role může dávat, nebo rušit jenom Super Admin.";
            } else{
                $user = $this->db->getUser($_POST['id_user']);
                $update = $this->db->updateUser($_POST["id_user"], $user[0]["username"], $user[0]["heslo"], $user[0]["email"], $_POST["pravo"]);
                if ($update) {
                    $tplData['success'] = "OK";
                    $tplData['delete'] = "Uživateli s ID:$_POST[id_user] se podařilo změnit právo.";
                } else {
                    $tplData['success'] = "ERROR";
                    $tplData['delete'] = "Uživateli s ID:$_POST[id_user] se nepodařilo změnit právo.";
                }
            }
        }

        if(isset($_POST['action'])){
            if($_POST['action'] == 'logout'){
                $this->db->userLogout();
                header("Location: http://localhost/WEB/index.php");
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