<?php

class MyLogin{

    private $ses;
    private $dbName = "jmeno";
    private $dbDate = "datum";

    public function __construct(){
        include_once("MySession.php");
        $this->ses = new MySession();
    }

    public function inUserLogged(){
        return $this->ses->isSessionSet($this->dbName);
    }

    public function login($userName){
        $this->ses->addSession($this->dbName.$userName);
        $this->ses->addSession($this->dbDate.date("d. m. Y, G:m:s "));
    }

    public function logout(){
        $this->ses->removeSession($this->dbName);
        $this->ses->removeSession($this->dbDate);
    }

    public function getUserInfo(){
        $name = $this->ses->readSession($this->dbName);
        $date = $this->ses->readSession($this->dbDate);
        return "Jméno: $name<br>Datum: $date<br>";
    }
}