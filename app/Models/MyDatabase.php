<?php

/**
 * Class what administrate database
 */
class MyDatabase{


    private $pdo;
    /** @var string $mySession owns object for administration session*/
    private $mySession;
    /** @var string $userSessionKey is key for user data, which is saved in the session*/
    private $userSessionKey = "curret_user_id";
    /** @var int $newReviewMode is value of mode 0 - new review, 1 - new review from menu (to a specific product), 2 - editing review */
    private $newReviewMode = "new_review_mode";
    /** @var int $reviewId is key of edited review */
    private $reviewId = "curret_review_id";

    public function __construct(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=sp_kiv_web", "root", "");
        $this->pdo->exec("set names utf8");

        require_once("MySession.php");
        $this->mySession = new MySession();
    }

    /**
     * It performs a query and either returns the retrieved data, or if an error occurs, it prints it and returns null.
     *
     * @param string $query
     * @return PDOStatement|null
     */
    private function executeQuery(string $query){
        $res = $this->pdo->query($query);

        if($res){
            return $res;
        }else{
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        }
    }

    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderStatement = ""):array {
        $q = "SELECT * FROM ". $tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderStatement == "") ? "" : " ORDER BY $orderStatement");

        $obj = $this->executeQuery($q);

        if($obj == null){
            return [];
        }

        return $obj->fetchAll();
    }

    /**
     * Function deletes row from table
     * @param string $tableName name of table
     * @param string $whereStatement which row will be deleted
     * @return bool deletion success
     */
    public function deleteFromTable(string $tableName, string $whereStatement){

        $q = "DELETE FROM $tableName WHERE $whereStatement";

        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Function inserts row into the table
     * @param string $tableName name of the table
     * @param string $insertStatename statement of insert
     * @param string $insertValues insert value
     * @return bool insertion success
     */
    public function insertIntoTable(string $tableName, string $insertStatename, string $insertValues):bool {

        $q = "INSERT INTO $tableName($insertStatename) VALUES ($insertValues)";

        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Function update a row in table
     * @param string $tableName name of the table
     * @param string $updateStatementWithValues statement with values
     * @param string $whereStatement where will the data updated
     * @return bool was update successfully
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {

        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        $obj = $this->executeQuery($q);

        if($obj == null){
            return false;
        }else{
            return true;
        }
    }

    function getAllUsers(){
        $users = $this->selectFromTable("lrunt_uzivatel", "", "id_uzivatel");
        return $users;
    }

    function getAllRights(){
        return $this->selectFromTable("lrunt_pravo", "", "id_pravo");
    }

    function getAllProducts(){
        return $this->selectFromTable("lrunt_produkt", "", "id_produkt");
    }

    function getAllTypesOfProducts(){
        return $this->selectFromTable("lrunt_typ_produktu", "", "id_typ");
    }

    function getAllReviews(){
        return $this->selectFromTable("lrunt_recenze", "", "id_recenze");
    }

    function getUserReviews(int $idUzivatel){
        return $this->selectFromTable("lrunt_recenze", "'$idUzivatel'=id_uzivatel", "id_recenze");
    }

    public function addNewUser(string $username, string $password, string $email, int $idPravo = 3){
        $insertStatement = "username, heslo, email, id_pravo";
        $insertValues = "'$username', '$password', '$email', '$idPravo'";
        return $this->insertIntoTable("lrunt_uzivatel", $insertStatement, $insertValues);
    }

    public function addNewProduct(string $name, string $photo, int $price, string $quantity){
        $insertStatement = "nazev, photo, cena, mnozstvi";
        $insertValues = "'$name', '$photo', '$price', '$quantity'";
        return $this->insertIntoTable("lrunt_produkt", $insertStatement, $insertValues);
    }

    public function addNewReview(int $idUser, int $idProduct, int $rating, int $published, string $date, string $text){
        $insertStatement = "id_uzivatel, id_produkt, hodnoceni, zverejneno, datum, popis";
        $inserValues = "'$idUser', '$idProduct', '$rating', '$published', '$date', '$text'";
        return $this->insertIntoTable("lrunt_recenze", $insertStatement, $inserValues);
    }

    public function addNewReview2(int $idUser, int $rating, int $published, string $date, string $text){
        $insertStatement = "id_uzivatel, hodnoceni, zverejneno, datum, popis";
        $inserValues = "'$idUser', '$rating', '$published', '$date', '$text'";
        return $this->insertIntoTable("lrunt_recenze", $insertStatement, $inserValues);
    }

    public function updateUser(int $idUzivatel, string $username, string $password, string $email, int $idPravo){
        $updateStatementWithValues = "username='$username', heslo='$password', email='$email', id_pravo='$idPravo'";
        $whereStatement = "id_uzivatel=$idUzivatel";
        return $this->updateInTable(TABLE_UZIVATEL, $updateStatementWithValues, $whereStatement);
    }

    public function updateReview(int $idReview, int $idUser, int $idProduct, int $rating, int $published, string $date, string $description){
        if($idProduct != -1){
            $updateStatementWithValues = "id_uzivatel='$idUser', id_produkt='$idProduct', hodnoceni='$rating', zverejneno='$published', datum='$date',popis='$description'";
        } else{
            $updateStatementWithValues = "id_uzivatel='$idUser', id_produkt=NULL, hodnoceni='$rating', zverejneno='$published', datum='$date',popis='$description'";
        }
        $whereStatement = "id_recenze=$idReview";
        return $this->updateInTable(TABLE_RECENZE, $updateStatementWithValues, $whereStatement);
    }

    public function getUser(int $idUzivatel){
        $where = "id_uzivatel='$idUzivatel'";
        return $this->selectFromTable(TABLE_UZIVATEL, $where);;
    }

    public function getReview(int $idReview){
        $where = "id_recenze='$idReview'";
        return $this->selectFromTable(TABLE_RECENZE, $where);
    }

    public function deleteUser(int $userId){
        $whereStatement =  "id_uzivatel = $userId";

        return $this->deleteFromTable(TABLE_UZIVATEL, $whereStatement);
    }

    public function deleteProduct(int $productId){
        $whereStatement = "id_produkt = $productId";

        return $this->deleteFromTable("lrunt_produkt", $whereStatement);
    }

    public function deleteReview(int $reviewId){
        $whereStatement = "id_recenze = $reviewId";

        return $this->deleteFromTable("lrunt_recenze", $whereStatement);
    }

    public function userExist(string $username){
        $where = "username='$username'";
        $user = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($user)){
            return true;
        }else{
            return false;
        }
    }

    public function emailIsTaken(string $email){
        $where = "email='$email'";
        $user = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($user)){
            return true;
        }else{
            return false;
        }
    }

    public function userLogin(string $username){
        $where = "username='$username'";
        $user = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($user)){
            $_SESSION[$this->userSessionKey] = $user[0]["id_uzivatel"];
            return true;
        } else{
            return false;
        }
    }

    public function userGetHash(string $username){
        $where =  "username='$username'";
        $user = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($user)){
            return $user[0]['heslo'];
        }
    }

    public function getUserRole(int $roleId){
        $where = "id_pravo=$roleId";
        $role = $this->selectFromTable("lrunt_pravo", $where);

        if(count($role)){
            return $role[0]['nazev'];
        }
    }

    /**
     * Logout of user
     */
    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test if user is logged
     *
     * @return bool Is user logged?
     */
    public function isUserLogged(){
        return isset($_SESSION[$this->userSessionKey]);
    }

    public function getLoggedUserData(){
        if($this->isUserLogged()){
            $userId = $_SESSION[$this->userSessionKey];
            if($userId == null){
                echo "SERVER ERROR: Data uživatele nebyla nalezena, a proto byl uživatel odhlášen";
                $this->userLogout();
                return null;
            }else{
                $userData = $this->selectFromTable("lrunt_uzivatel", "id_uzivatel=$userId");
                if(empty($userData)){
                    echo "ERROR: Data přihlášeného uživatele se nanachází v databázi.";
                    $this->userLogout();
                    return null;
                }else{
                    return $userData[0];
                }
            }
        }else{
            return null;
        }
    }

    public function setEditedReview(int $reviewId, int $mode){
        $where = "id_recenze='$reviewId'";
        $_SESSION[$this->newReviewMode] = $mode;
        $review = $this->selectFromTable("lrunt_recenze", $where);

        if(count($review)){
            $_SESSION[$this->reviewId] = $review[0]["id_recenze"];
            return true;
        } else{
            return false;
        }
    }

    public function getEditingReviewData(){
        if(isset($_SESSION[$this->reviewId])){
            $reviewId = $_SESSION[$this->reviewId];
            if($reviewId == null){
                echo "SERVER ERROR: Recenze nenalezena";
                return null;
            }else{
                $reviewData = $this->selectFromTable("lrunt_recenze", "id_recenze=$reviewId");
                if(empty($reviewData)){
                    echo "ERROR: Data recenze se nanachází v databázi.";
                    return null;
                }else{
                    return $reviewData[0];
                }
            }
        }else{
            return null;
        }
    }

    public function getNewReviewMode(){
        return $_SESSION[$this->newReviewMode];
    }

    public function reviewEdited(){
        $_SESSION[$this->newReviewMode] = 0;
        unset($_SESSION[$this->reviewId]);
    }

    /**
     * Function gets a weight of user rights
     * @param string $idRight rights id
     * @return int|mixed weight of rights
     */
    public function getWeightOfRight(string $idRight){
        $rightData = $this->selectFromTable("lrunt_pravo", "id_pravo=$idRight");
        if($rightData == null){
            return 0;
        }
        return $rightData['0']['vaha'];
    }
}

?>