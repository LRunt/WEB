<?php

require_once(DIRECTORY_CONTROLLERS."/IController.php");

class MenuController implements IController{

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

        $tplData['products'] = $this->db->getAllProducts();

        $ratings = [];
        foreach($tplData['products'] as $product){
            $res = $this->db->getAverageRating($product['id_produkt']);
            if($res == null){
                $ratings[$product['id_produkt']] = 'N/A';
            }else{
                $ratings[$product['id_produkt']] = $res;
            }
        }
        $tplData['average_ratings'] = $ratings;

        ob_start();

        require_once(DIRECTORY_VIEWS ."/MenuTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>