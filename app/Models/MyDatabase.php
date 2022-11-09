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
            echo "<script>console.log($error[2]);</script>";
            return null;
        }
    }

    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderStatement = "", string $column = "*"):array {

        $q = "SELECT " . $column . " FROM ". $tableName
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

        //XSS control
        $insertValues = htmlspecialchars($insertValues);

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

        //XSS control
        $updateStatementWithValues = htmlspecialchars($updateStatementWithValues);

        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        $obj = $this->executeQuery($q);

        if($obj == null){
            return false;
        }else{
            return true;
        }
    }

    function getAllUsers(){
        $q = "SELECT * FROM lrunt_uzivatel ORDER BY id_uzivatel;";
        $res = $this->pdo->query($q);
        if($res){
            return $res->fetchAll();
        }
        return null;
    }

    function getAllRights(){
        $q = "SELECT * FROM lrunt_pravo ORDER BY id_pravo;";
        $res = $this->pdo->query($q);
        if($res){
            return $res->fetchAll();
        }
        return null;
    }

    function getAllProducts(){
        $q = "SELECT * FROM lrunt_produkt ORDER BY id_produkt;";
        $res = $this->pdo->query($q);
        if($res){
            return $res->fetchAll();
        }
        return null;
    }

    function getAllTypesOfProducts(){
        $q = "SELECT * FROM lrunt_typ_produktu ORDER BY id_typ;";
        $res = $this->pdo->query($q);
        if($res){
            return $res->fetchAll();
        }
        return null;
    }

    function getAllReviews(){
        $q = "SELECT * FROM lrunt_recenze ORDER BY datum DESC;";
        $res = $this->pdo->query($q);
        if($res){
            return $res->fetchAll();
        }
        return null;
    }

    function getUserReviews(int $userId){
       $userId = htmlspecialchars($userId);

        $q = "SELECT * FROM lrunt_recenze WHERE id_uzivatel=:userId ORDER BY datum DESC;";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":userId", $userId);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }

    public function addNewUser(string $username, string $password, string $email, int $idPravo = 4){
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $email = htmlspecialchars($email);
        $idPravo = htmlspecialchars($idPravo);

        $q= "INSERT INTO lrunt_uzivatel(username, heslo, email, id_pravo) VALUES (:username, :password, :email, :idPravo)";

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":idPravo", $idPravo);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function addNewProduct(string $name, string $photo, int $price, string $quantity, int $type){
        $name = htmlspecialchars($name);
        $photo = htmlspecialchars($photo);
        $price = htmlspecialchars($price);
        $quantity = htmlspecialchars($quantity);
        $type = htmlspecialchars($type);

        $q = "INSERT INTO lrunt_produkt(nazev, photo, cena, mnozstvi, id_typ) VALUES (:name, :photo, :price, :quantity, :type)";

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":photo", $photo);
        $stmt->bindValue(":price", $price);
        $stmt->bindValue(":quantity", $quantity);
        $stmt->bindValue(":type", $type);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function addNewReview(int $idUser, int $idProduct, int $rating, int $published, string $date, string $text){
        $idUser = htmlspecialchars($idUser);
        $idProduct = htmlspecialchars($idProduct);
        $rating = htmlspecialchars($rating);
        $published = htmlspecialchars($published);
        $date = htmlspecialchars($date);
        $text = htmlspecialchars($text);

        $q = "INSERT INTO lrunt_recenze(id_uzivatel, id_produkt, hodnoceni, zverejneno, datum, popis) VALUES (:idUser, :idProduct, :rating, :published, :date, :text)";

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":idUser", $idUser);
        $stmt->bindValue(":idProduct", $idProduct);
        $stmt->bindValue(":rating", $rating);
        $stmt->bindValue(":published", $published);
        $stmt->bindValue(":date", $date);
        $stmt->bindValue(":text", $text);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function addNewReview2(int $idUser, int $rating, int $published, string $date, string $text){
        $idUser = htmlspecialchars($idUser);
        $rating = htmlspecialchars($rating);
        $published = htmlspecialchars($published);
        $date = htmlspecialchars($date);
        $text = htmlspecialchars($text);

        $q = "INSERT INTO lrunt_recenze(id_uzivatel, hodnoceni, zverejneno, datum, popis) VALUES (:idUser, :rating, :published, :date, :text)";

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":idUser", $idUser);
        $stmt->bindValue(":rating", $rating);
        $stmt->bindValue(":published", $published);
        $stmt->bindValue(":date", $date);
        $stmt->bindValue(":text", $text);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function updateUser(int $idUzivatel, string $username, string $password, string $email, int $idPravo){
        $idUzivatel = htmlspecialchars($idUzivatel);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $email = htmlspecialchars($email);
        $idPravo = htmlspecialchars($idPravo);

        $q = "UPDATE lrunt_uzivatel SET username=:username, heslo=:password, email=:email, id_pravo=:idPravo WHERE id_uzivatel=:idUzivatel";

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":idUzivatel", $idUzivatel);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":idPravo", $idPravo);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateReview(int $idReview, int $idUser, int $idProduct, int $rating, int $published, string $date, string $description){
        $idReview = htmlspecialchars($idReview);
        $idUser = htmlspecialchars($idUser);
        $idProduct = htmlspecialchars($idProduct);
        $rating = htmlspecialchars($rating);
        $published = htmlspecialchars($published);
        $date = htmlspecialchars($date);
        $description = htmlspecialchars($description);

        if($idProduct != -1){
            $q = "UPDATE lrunt_recenze SET id_uzivatel=:idUser, id_produkt=:idProduct, hodnoceni=:rating, zverejneno=:published, datum=:date, popis=:description WHERE id_recenze=:idReview";
        } else{
            $q = "UPDATE lrunt_recenze SET id_uzivatel=:idUser, id_produkt=NULL, hodnoceni=:rating, zverejneno=:published, datum=:date, popis=:description WHERE id_recenze=:idReview";
        }

        $stmt = $this->pdo->prepare($q);

        $stmt->bindValue(":idReview", $idReview);
        $stmt->bindValue(":idUser", $idUser);
        $stmt->bindValue(":rating", $rating);
        $stmt->bindValue(":published", $published);
        $stmt->bindValue(":date", $date);
        $stmt->bindValue(":description", $description);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getUser(int $userId){
        $userId = htmlspecialchars($userId);

        $q = "SELECT * FROM lrunt_uzivatel WHERE id_uzivatel=:userId";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":userId", $userId);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }

    public function getReview(int $idReview){
        $idReview = htmlspecialchars($idReview);

        $q = "SELECT * FROM lrunt_recenze WHERE id_recenze=:idReview";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":idReview", $idReview);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }

    public function getMenu(){
        $menu = [];
        $types = $this->getAllTypesOfProducts();
        for($i = 0; $i < count($types); $i++){
            $menu[$i] = $this->getSubMenu($types[$i]);
        }
        return $menu;
    }

    public function getSubMenu($type){
        $submenu = [];
        $submenu[1] = $type;
        $submenu[2] = $this->getProductsByType($type['id_typ']);
        return $submenu;
    }

    public function getProductsByType($type){
        $type = htmlspecialchars($type);

        $q = "SELECT * FROM lrunt_produkt WHERE id_typ=:type";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":type", $type);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }

    public function getAverageRating(int $idProduct){
        $idProduct = htmlspecialchars($idProduct);

        $q = "SELECT AVG(hodnoceni) FROM lrunt_recenze WHERE id_produkt=:idProdukt AND zverejneno=1";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":idProdukt", $idProduct);
        if($stmt->execute()){
            $array = $stmt->fetchAll();
            return $array[0][0];
        }
        return null;
    }

    public function getImageName(int $idProduct){
        $idProduct = htmlspecialchars($idProduct);

        $q = "SELECT photo FROM lrunt_produkt WHERE id_produkt=:idProdukt";
        $stmt = $this->pdo->prepare($q);
        $stmt->bindValue(":idProdukt", $idProduct);
        if($stmt->execute()){
            $array = $stmt->fetchAll();
            return $array[0][0];
        }
        return null;
    }

    public function haveProductReview(int $idProduct){
        $where = "id_produkt='$idProduct'";
        $res = $this->selectFromTable(TABLE_RECENZE, $where);
        if(count($res)){
            return true;
        }else{
            return false;
        }
    }

    public function haveUserReview(int $idUser){
        $where = "id_uzivatel='$idUser'";
        $res = $this->selectFromTable(TABLE_RECENZE, $where);
        if(count($res)){
            return true;
        }else{
            return false;
        }
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

    public function getUserRights(int $userId){
        $where = "id_uzivatel=$userId";
        $role = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($role)){
            return $this->getUserRole($role[0]['id_pravo']);
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
                echo "<script>console.log('SERVER ERROR: Data uživatele nebyla nalezena, a proto byl uživatel odhlášen');</script>";
                $this->userLogout();
                return null;
            }else{
                $userData = $this->selectFromTable("lrunt_uzivatel", "id_uzivatel=$userId");
                if(empty($userData)){
                    echo "<script>console.log('ERROR: Data přihlášeného uživatele se nanachází v databázi.');</script>";
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
                echo "<script>console.log('SERVER ERROR: Recenze nenalezena');</script>";
                return null;
            }else{
                $reviewData = $this->selectFromTable("lrunt_recenze", "id_recenze=$reviewId");
                if(empty($reviewData)){
                    echo "<script>console.log('ERROR: Data recenze se nanachází v databázi.');</script>";
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