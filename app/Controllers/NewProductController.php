<?php

require_once(DIRECTORY_CONTROLLERS."/IController.php");

class NewProductController implements IController{

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
        if($tplData['isLogged']) {
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
            $tplData['typesOfProducts'] = $this->db->getAllTypesOfProducts();
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

        $tplData['product'] = $this->db->getAllProducts();

        if(isset($_POST['name'])){
            /*$filename = $_FILES["photo"]["name"];
            $tempname = $_FILES["photo"]["tmp_name"];*/

            $res = $this->db->addNewProduct($_POST['name'], $_POST['photo'], $_POST['price'], $_POST['quantity']);
            echo "add";

        }

        ob_start();

        require_once(DIRECTORY_VIEWS ."/NewProductTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>