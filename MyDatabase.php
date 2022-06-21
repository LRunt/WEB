<?php

/**
 * Class what administrate database
 */
class MyDatabase{

    private $pdo;

    public function __constructor(){
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
    }

    function getAllUsers(){
        $q = "SELECT * FROM".TABLE_UZIVATEL."ORDER BY jmeno";

        $res = $this->pdo->query($q);

        if(!$res){
            return[];
        }else{
            return $res->fetchAll();
        }
    }
}

?>