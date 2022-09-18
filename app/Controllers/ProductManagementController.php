<?php

    require_once(DIRECTORY_CONTROLLERS."/IController.php");

    class ProductManagementController implements IController {

        private $db;

        public function __construct(){
            require_once (DIRECTORY_MODELS."/MyDatabase.php");
            $this->db = new MyDatabase();
        }

        public function show(string $pageTitle): string{

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
                }else if($_POST['action'] == 'newProduct'){
                    header("Location: http://localhost/WEB/index.php?page=newProduct");
                }
            }

            if(isset($_POST['action']) and $_POST['action'] == "delete" and isset($_POST['id_produkt'])){
                echo $_POST['id_produkt'];
                $res = $this->db->deleteProduct($_POST['id_produkt']);
                echo $res;
            }

            $tplData['products'] = $this->db->getAllProducts();

            ob_start();

            require_once(DIRECTORY_VIEWS."/ProductManagementTemplate.php");

            $obsah = ob_get_clean();

            return $obsah;
        }
    }

?>