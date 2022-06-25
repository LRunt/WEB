<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    if(!$tplData['isLogged']){
        $res .= " <h2>Přihlášení uživatele</h2>

    <form action='' method='POST'>
        <table>
            <tr><td>Login:</td><td><input type='text' name='username'></td></tr>
            <tr><td>Heslo:</td><td><input type='password' name='heslo'></td></tr>
        </table>
        <input type='hidden' name='action' value='login'>
        <input type='submit' name='potvrzeni' value='Přihlásit'>
        <a href='user-registration.inc.php'>Nemám účet</a>
    </form>";
    }else{
        $res .= "
                 <h2>Přihlášený uživatel</h2>
        Odhlášení uživatele:
        <form action='' method='POST'>
            <input type='hidden' name='action' value='logout'>
            <input type='submit' name='potvrzeni' value='Odhlásit'>
        </form>
        ";
    }
    $res .= " 
            ";

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
