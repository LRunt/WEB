<?php

    require_once("MyDatabase.php");
    $db = new MyDatabase();

?>

    <h2>Přihlášení uživatele</h2>

    <form action="" method="POST">
        <table>
            <tr><td>Login:</td><td><input type="text" name="login"></td></tr>
            <tr><td>Heslo:</td><td><input type="password" name="heslo"></td></tr>
        </table>
        <input type="hidden" name="action" value="login">
        <input type="submit" name="potvrzeni" value="Přihlásit">
        <a href="user-registration.inc.php">Nemám účet</a>
    </form>
