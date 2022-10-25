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
        $tplData['error'] = "";
        $tplData['username'] = "";

        if(isset($_POST['action'])){
            if($_POST['action'] == 'login' && isset($_POST['username']) && isset($_POST['heslo'])){
                if(password_verify($_POST['heslo'], $this->db->userGetHash($_POST['username']))){
                    $res = $this->db->userLogin($_POST['username']);
                    if($res){
                        $tplData['username'] = '';
                        #echo "OK: uživatel byl přihlášen";
                    }else{
                        $tplData['error'] = "Neplatné uživatelské jméno nebo špatné heslo";
                        $tplData['username'] = $_POST['username'];
                    }
                } else{
                    $tplData['error'] = "Neplatné uživatelské jméno nebo špatné heslo";
                    $tplData['username'] = $_POST['username'];
                }
            }elseif ($_POST['action'] == 'logout'){
                $this->db->userLogout();
                #echo "OK: Uživatel byl odhlášen.";
            }elseif ($_POST['action'] == 'delete'){
                $res = $this->db->deleteReview($_POST['id_review_delete']);
            }elseif ($_POST['action'] == 'edit'){
                echo "Edit";
            }else{
                #echo "WARNING: neznámá akce";
            }
        }

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']) {
            $tplData['user'] = $this->db->getLoggedUserData();
            $user = $tplData['user'];
            $tplData['reviews'] = $this->db->getUserReviews($user['id_uzivatel']);
            $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
            $tplData['role'] = $this->db->getUserRole($tplData['user']['id_pravo']);
        }

        ob_start();

        require_once(DIRECTORY_VIEWS ."/LoginTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}
?>