<?php

    require_once("MyDatabase.php");
    $db = new MyDatabase();

    $users = $db->getAllUsers();

    var_dump($users);

?>