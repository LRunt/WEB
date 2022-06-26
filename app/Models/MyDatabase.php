<?php

/**
 * Class what administrate database
 */
class MyDatabase{


    private $pdo;
    /** @var string $mySession owns object for administration session*/
    private $mySession;
    /** @var string $userSessionKey is key fo user data, which is saved in the session*/
    private $userSessionKey = "curret_user_id";

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

    public function addNewUser(string $username, string $password, string $email, int $idPravo = 3){
        $insertStatement = "username, heslo, email, id_pravo";
        $insertValues = "'$username', '$password', '$email', '$idPravo'";
        return $this->insertIntoTable("lrunt_uzivatel", $insertStatement, $insertValues);
    }

    public function updateUser(int $idUzivatel, string $username, string $password, string $email, int $idPravo){
        $updateStatementWithValues = "username='$username', heslo='$password', email='$email', id_pravo='$idPravo'";
        $whereStatement = "id_uzivatel=$idUzivatel";
        return $this->updateInTable(TABLE_UZIVATEL, $updateStatementWithValues, $whereStatement);
    }

    public function getUser(int $idUzivatel){
        $where = "id_uzivatel='$idUzivatel'";
        return $this->selectFromTable("lrunt_uzivatel", $where);;
    }

    public function deleteUser(int $userId){
        $whereStatement =  "id_uzivatel = $userId";

        return $this->deleteFromTable("lrunt_uzivatel", $whereStatement);
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

    public function userLogin(string $username, string $password){
        $where = "username='$username' AND heslo='$password'";
        $user = $this->selectFromTable("lrunt_uzivatel", $where);

        if(count($user)){
            $_SESSION[$this->userSessionKey] = $user[0]["id_uzivatel"];
            return true;
        } else{
            return false;
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
}

?>