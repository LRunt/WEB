<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "<div class='row d-flex align-items-start justify-content-start h-100'>
<h1>Jídelní lístek</h1>";

    foreach($tplData['product'] as $f) {
        $res .="
            <h6><b>$f[nazev]</b></h6><br>";

        $averageRating = $tplData['average_ratings'][$f['id_produkt']];

        $res .= "
             <div style='width: 150px; float:left; margin:10px'>
                <img src='$f[photo]' class='img-fluid' alt='ukazka jidla' width='200' height='100'>
             </div>
             <div style='width: 45%; float:left; margin:10px'>
                <b>Cena: </b> $f[cena]Kč<br>
                <b>Množství: </b> $f[mnozstvi]<br>
                <b>Průměrné hodnocení: </b> $averageRating*<br>
             </div>
             <hr>
            ";
    }

    $res .='</div>';

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
