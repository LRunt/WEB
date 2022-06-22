<?php

class MySession
{

    /**
     *
     */
    public function __construct(){
        session_start();
    }

    /**
     * Function for adding data to the session
     * @param string $name atribut key
     * @param $value value
     */
    public function addSession(string $name, $value){
        $_SESSION[$name] = $value;
    }

    /**
     * Raeds the session
     * @param string $name
     * @return mixed|null
     */
    public function readSession(string $name){
        if($this->isSessionSet($name)){
            return $_SESSION[$name];
        }else{
            return null;
        }
    }

    /**
     * if is the session set
     * @param string $name name of the session
     * @return bool is session set
     */
    public function isSessionSet(string $name){
        return isset($_SESSION[$name]);
    }

    /**
     * deletes session
     * @param string $name name of the session
     */
    public function removeSession(string $name){
        unset($_SESSION[$name]);
    }

}

?>