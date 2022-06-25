<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();
?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    if(isset($tplData['delete'])){
        echo "<div class='alert'>$tplData[delete]</div>";
    }
    $res = "<h2>Seznam uživatelů</h2>
            <table border='1'><tr><th>ID</th><th>Username</th><th>E-mail</th><th>Právo</th><th>Smazat</th></tr>";
                // projdu data a vypisu radky tabulky
                foreach($tplData['users'] as $u){
    $res .= "<tr><td>$u[id_uzivatel]</td><td>$u[username]</td><td>$u[email]</td><td>$u[id_pravo]</td>"
                    ."<td><form method='post'>"
                            ."<input type='hidden' name='id_user' value='$u[id_uzivatel]'>"
                            ."<button type='submit' name='action' value='delete'>Smazat</button>"
                            ."</form></td></tr>";
                }
    $res .= "</table>";

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
