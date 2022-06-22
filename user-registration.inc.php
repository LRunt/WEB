<?php

    require_once("MyDatabase.php");
    $db = new MyDatabase();

    if(!empty($_POST['potvrzeni'])){
        // mam vsechny pozadovane hodnoty?
        if(!empty($_POST['username']) && !empty($_POST['heslo']) && !empty($_POST['heslo2'])
            && !empty($_POST['email'])
            && $_POST['heslo'] == $_POST['heslo2']
        ){
            // pozn.: heslo by melo byt sifrovano
            // napr. password_hash($password, PASSWORD_BCRYPT) pro sifrovani
            // a password_verify($password, $hash) pro kontrolu hesla.

            // mam vsechny atributy - ulozim uzivatele do DB
            $res = $db->addNewUser($_POST['username'], $_POST['heslo'], $_POST['email']);
            // byl ulozen?
            if($res){
                echo "OK: Uživatel byl přidán do databáze.";
            } else {
                echo "ERROR: Uložení uživatele se nezdařilo.";
            }
        } else {
            // nemam vsechny atributy
            echo "ERROR: Nebyly přijaty požadované atributy uživatele.";
        }
        echo "<br><br>";
    }
?>

    <h2>Registrační formulář</h2>
    <form action="" method="POST" oninput="x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla'">
        <table>
            <tr><td>Přezdívka:</td><td><input type="text" name="username" required></td></tr>
            <tr><td>E-mail:</td><td><input type="email" name="email" required></td></tr>
            <tr><td>Heslo:</td><td><input type="password" name="heslo" id="pas1" required></td></tr>
            <tr><td>Heslo (znovu):</td><td><input type="password" name="heslo2" id="pas2" required></td></tr>
        </table>

        <input type="submit" name="potvrzeni" value="Registrovat">
    </form>