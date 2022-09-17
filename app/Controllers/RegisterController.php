<?php

class RegisterController implements IController {

    /** @var DatabaseModel $db is for administration of the database */
    private $db;

    /**
     * Initialization of the connection to the database
     */
    public function __construct(){
        require_once(DIRECTORY_MODELS."/MyDatabase.php");
        $this->db = new MyDatabase();
    }

    public function show(string $pageTitle):string{
        global $tplData;
        $tplData = [];

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']){
            $tplData['user'] = $this->db->getLoggedUserData();
            $tplData['weight'] = $this->db->getWeightOfRight($tplData['user']['id_pravo']);
        }

        if(!empty($_POST['username']) && !empty($_POST['heslo']) && !empty($_POST['heslo2'])
            && !empty($_POST['email'])
            && $_POST['heslo'] == $_POST['heslo2']
        ){
            if($this->db->userExist($_POST['username'])){
                #echo "Prezdivka zabrana!";
            }else{
                // pozn.: heslo by melo byt sifrovano
                // napr. password_hash($password, PASSWORD_BCRYPT) pro sifrovani
                // a password_verify($password, $hash) pro kontrolu hesla.

                // mam vsechny atributy - ulozim uzivatele do DB
                $res = $this->db->addNewUser($_POST['username'], $_POST['heslo'], $_POST['email']);
                // byl ulozen?
                if($res){
                    #echo "OK: Uživatel byl přidán do databáze.";
                    $res = $this->db->userLogin($_POST['username'], $_POST['heslo']);
                    header('Location: http://localhost/WEB/index.php?page=login');
                } else {
                    #echo "ERROR: Uložení uživatele se nezdařilo.";
                }
            }
        } else {
            // nemam vsechny atributy
            #echo "ERROR: Nebyly přijaty požadované atributy uživatele.";
        }

        $tplData['title'] = $pageTitle;

        ob_start();

        require_once(DIRECTORY_VIEWS ."/RegisterTemplate.php");

        $obsah = ob_get_clean();

        return $obsah;
    }
}