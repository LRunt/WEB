<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "<h1>Jídelní lístek</h1>
                <div class='table-responsive'>
                <table class='table align-middle mb-0 bg-white'>
                    <thead class='bg-light'>
                        <tr>
                        <th>Pokrm</th>
                        <th>Cena</th>
                        <th>Množství</th>
                        </tr>
                    </thead><tbody>";

    foreach($tplData['food'] as $f) {
        $res .="<tr>
            <th scope='row'>$f[nazev]</th>
            <td>$f[cena] Kč</td>
            <td>$f[mnozstvi]</td></tr>";
    }

    $res .= "</tbody>
              </table>
              </div>";

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
