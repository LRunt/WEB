<?php

    require_once("MyDatabase.php");
    $db = new MyDatabase();

    //var_dump($users);

    if(isset($_POST['id_uzivatel'])){
        $res = $db->deleteFromTable("lrunt_uzivatel", "id_uzivatel='$_POST[id_uzivatel]'");

        if($res){
            echo "OK: uživatel byl smazán z databáze.";
        }else{
            echo "ERROR: Smazání uživatele se nezdařilo.";
        }
    }

    $users = $db->getAllUsers();

?>

    <div>
        <b>Správu uživatelů mohou provádět pouze uživatelé s právem Administrátor.</b>
    </div>

    <h2>Seznam uživatelů</h2>
    <table border="1">
        <tr><th>ID</th><th>Username</th><th>E-mail</th><th>Právo</th><th>Smazat</th>
        <?php
        // projdu uzivatele a vypisu je
            foreach ($users as $u) {
                echo "<tr><td>$u[id_uzivatel]</td><td>$u[username]</td><td>$u[email]</td><td>$u[id_pravo]</td><td>"
                    ."<form action='' method='POST'>
                              <input type='hidden' name='id_uzivatel' value='$u[id_uzivatel]'>
                              <input type='submit' name='potvrzeni' value='Smazat'>
                          </form>"
                    ."</td></tr>";
            }
        ?>
    </table>

