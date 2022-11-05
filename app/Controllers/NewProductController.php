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
                header("Location: http://localhost/WEB/index.php");
                #echo "OK: Uživatel byl odhlášen.";
            }else{
                #echo "WARNING: neznámá akce";
            }
        }

        $tplData['product'] = $this->db->getAllProducts();

        if(isset($_POST['name'])){
            $target_dir = "data/products/";
            $photo = date("Ymdhis").$tplData['user']['username']."-";
            $target_file = $target_dir . $photo . basename($_FILES["photo"]["name"]);


            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

            $res = $this->db->addNewProduct($_POST['name'], $target_file, $_POST['price'], $_POST['quantity'], $_POST['type']);

            header('Location: http://localhost/WEB/index.php?page=productManagement');
        }

        ob_start();

        require_once(DIRECTORY_VIEWS ."/NewProductTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>