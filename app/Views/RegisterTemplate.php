<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    $res .=" <h2>Registrační formulář</h2>
                <form action='' method='POST' oninput='x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla''>
                    <table>
                        <tr><td>Přezdívka:</td><td><input type='text' name='username' required></td></tr>
                        <tr><td>E-mail:</td><td><input type='email' name='email' required></td></tr>
                        <tr><td>Heslo:</td><td><input type='password' name='heslo' id='pas1' required></td></tr>
                        <tr><td>Heslo (znovu):</td><td><input type='password' name='heslo2' id='pas2' required></td></tr>
                    </table>
                    <input type='submit' name='potvrzeni' value='Registrovat'>
                    </form>";

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
