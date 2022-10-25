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

        $tplData['error'] = "";
        $tplData['username'] = "";
        $tplData['email'] = "";
        $tplData['password'] = "";
        $tplData['password2'] = "";

        $tplData['isLogged'] = $this->db->isUserLogged();
        if($tplData['isLogged']){
            $this->db->userLogout();
        }

        if(!empty($_POST['username']) && !empty($_POST['heslo']) && !empty($_POST['heslo2'])
            && !empty($_POST['email'])
        ){
            $tplData['username'] = $_POST['username'];
            $tplData['email'] = $_POST['email'];
            $tplData['password'] = $_POST['heslo'];
            $tplData['password2'] = $_POST['heslo2'];

            if($_POST['heslo'] != $_POST['heslo2']){
                $tplData['error'] = "Hesla nejsou stejná!";
                #echo "hesla nejsou stejná";
            } elseif(empty($_POST['souhlas'])){
                $tplData['error'] = "Potvrďte prosím souhlas s podmínkami užití.";
            } elseif ($this->db->userExist($_POST['username'])){
                $tplData['error'] = "Přezdívka je už zabrána jiným uživatelem.";
                #echo "Prezdivka zabrana!";
            }elseif ($this->db->emailIsTaken($_POST['email'])){
                $tplData['error'] = "Email je už použit u jiného účtu";
            }else{
                $hash = password_hash($_POST['heslo'], PASSWORD_BCRYPT);

                // mam vsechny atributy - ulozim uzivatele do DB
                $res = $this->db->addNewUser($_POST['username'], $hash, $_POST['email']);
                // byl ulozen?
                if($res){
                    #echo "OK: Uživatel byl přidán do databáze.";
                    $res = $this->db->userLogin($_POST['username']);
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