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

            $tplData['products'] = $this->db->getAllProducts();

            ob_start();

            require_once(DIRECTORY_VIEWS."/ProductManagementTemplate.php");

            $obsah = ob_get_clean();

            return $obsah;
        }
    }

?>