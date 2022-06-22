<?php

/**
 * Class what administrate database
 */
class MyDatabase{

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=sp_kiv_web", "root", "");
        $this->pdo->exec("set names utf8");
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

    function getAllUsers(){
        $users = $this->selectFromTable("lrunt_uzivatel", "", "username");
        return $users;
    }
}

?>