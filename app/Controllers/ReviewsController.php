<?php

require_once(DIRECTORY_CONTROLLERS."/IController.php");

class ReviewsController implements IController {

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
                header("Location: http://localhost/WEB/index.php");
                #echo "OK: Uživatel byl odhlášen.";
            }else if($_POST['action']=='hide'){
                $review = $this->db->getReview($_POST['id_review']);
                $this->db->updateReview($review[0]['id_recenze'], $review[0]['id_uzivatel'], $review[0]['id_produkt'], $review[0]['hodnoceni'], 0, $review[0]['datum'], $review[0]['popis']);
            }else if($_POST['action']=='publish'){
                $review = $this->db->getReview($_POST['id_review']);
                $this->db->updateReview($review[0]['id_recenze'], $review[0]['id_uzivatel'], $review[0]['id_produkt'], $review[0]['hodnoceni'], 1, $review[0]['datum'],$review[0]['popis']);
            }else if($_POST['action']=='newReview'){
                $res = $this->db->setEditedReview(-1, 0);
                header("Location: http://localhost/WEB/index.php?page=newReview");
            }elseif ($_POST['action']=='delete'){
                $this->db->deleteReview($_POST['id_review_delete']);
                //$tplData['info'] = "Recenze byla úspěšně smazána";
            }
        }

        $tplData['reviews'] = $this->db->getAllReviews();
        $tplData['users'] = $this->db->getAllUsers();
        $tplData['products'] = $this->db->getAllProducts();

        ob_start();

        require_once(DIRECTORY_VIEWS."/ReviewsTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}

?>