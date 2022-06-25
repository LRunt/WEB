<?php

class MyCookies{

    private $defExpire;

    public function __construct(int $defaultExpirationSec = (10 * 60 * 60 * 24)){
        $this->defExpire = $defaultExpirationSec;
    }

    public function setCookie(string $key, $value, $expire=null){
        if(!isset($expire)){
            $expire = $this->defExpire;
        }
        setcookie($key, $value, time()+$this->defExpire);
    }

    public function isCookieSet(string $key):bool{
        return isset($_COOKIE[$key]);
    }

    public function readCookie(string $key){
        if($this->isCookieSet($key)){
            return $_COOKIE[$key];
        }else{
            return null;
        }
    }

    public function removeCookie(string $key){
        $this->setCookie($key, null, 0);
    }
}