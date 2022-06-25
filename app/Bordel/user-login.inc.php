<?php

    require_once("MyDatabase.php");
    $db = new MyDatabase();

    if(isset($_POST['action'])){
        if($_POST['action'] == 'login' && isset($_POST['username']) && isset($_POST['heslo'])){
            $res = $db->userLogin($_POST['username'], $_POST['heslo']);
            if($res){
                echo "OK: uživatel byl přihlášen";
            }else{
                echo "ERROR: Přihlášení uživatele se nezdařilo.";
            }
        }

        else if($_POST['action'] == 'logout'){
            $db->userLogout();
            echo "OK: Uživatel byl odhlášen.";
        }else{
            echo "WARNING: neznámá akce";
        }
        echo "<br>";
    }

     // pokud je uzivatel prihlasen, tak ziskam jeho data
    if(!$db->isUserLogged()){

?>

    <h2>Přihlášení uživatele</h2>

    <form action="" method="POST">
        <table>
            <tr><td>Login:</td><td><input type="text" name="username"></td></tr>
            <tr><td>Heslo:</td><td><input type="password" name="heslo"></td></tr>
        </table>
        <input type="hidden" name="action" value="login">
        <input type="submit" name="potvrzeni" value="Přihlásit">
        <a href="user-registration.inc.php">Nemám účet</a>
    </form>

<?php
    }else{
        $user = $db->getLoggedUserData();

        $pravo = $db->getLoggedUserData();

        //$pravoNazev = ($pravo == null) ? "*neznámé*" : $pravo['nazev'];

    ///////////// KONEC: PRO NEPRIHLASENE UZIVATELE ///////////////

?>
        <h2>Přihlášený uživatel</h2>

        Přezdívka: <?php echo $user['username'] ; ?><br>
        heslo: <?php echo $user['heslo'] ; ?><br>
        E-mail: <?php echo $user['email'] ; ?><br>
        Právo: <?php echo ""?><br>
        <br>

        Odhlášení uživatele:
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input type="submit" name="potvrzeni" value="Odhlásit">
        </form>

<?php
    }

?>