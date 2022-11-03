<?php

    require_once(DIRECTORY_CONTROLLERS."/IController.php");

    class NewReviewController implements IController {

        private $db;

        public function __construct(){
            require_once (DIRECTORY_MODELS."/MyDatabase.php");
            $this->db = new MyDatabase();
            date_default_timezone_set('Europe/Prague');
        }

        public function show(string $pageTitle): string{

            global $tplData;
            $tplData = [];

            $tplData['title'] = $pageTitle;
            $tplData['mode'] = $this->db->getNewReviewMode();

            if($tplData['mode'] == 2){
                $tplData['reviewData'] = $this->db->getEditingReviewData();
            }

            $tplData['isLogged'] = $this->db->isUserLogged();
            if($tplData['isLogged']){
                $tplData['user'] = $this->db->getLoggedUserData();
                $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
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

            $tplData['products'] = $this->db->getAllProducts();

            if(isset($_POST['text'])){
                $rating = 0;
                if(isset($_POST['rate'])){
                    $rating = $_POST['rate'];
                }
                if($tplData['mode'] == 0 || $tplData['mode'] == 1){
                    if($_POST['product'] != 'NULL'){
                        $res = $this->db->addNewReview($tplData['user']['id_uzivatel'], $_POST['product'], $rating, 0, date("Y-m-d H:i:s"), $_POST['text']);
                    }else{
                        $res = $this->db->addNewReview2($tplData['user']['id_uzivatel'], $rating, 0, date("Y-m-d H:i:s"), $_POST['text']);
                    }
                    header('Location: http://localhost/WEB/index.php?page=reviews');
                }
                if($tplData['mode'] == 2){
                    if($_POST['product'] != 'NULL'){
                        $res = $this->db->updateReview($tplData['reviewData']['id_recenze'], $tplData['user']['id_uzivatel'], $_POST['product'], $rating, 0, date("Y-m-d H:i:s"), $_POST['text']);
                    }else{
                        $res = $this->db->updateReview($tplData['reviewData']['id_recenze'], $tplData['user']['id_uzivatel'], -1, $rating, 0, date("Y-m-d H:i:s"), $_POST['text']);
                    }
                    header('Location: http://localhost/WEB/index.php?page=login');
                }


            }

            ob_start();

            require_once(DIRECTORY_VIEWS."/NewReviewTemplate.php");

            $obsah = ob_get_clean();

            return $obsah;
        }
    }

?>