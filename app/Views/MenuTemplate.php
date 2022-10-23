<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "<h1>Jídelní lístek</h1>";

    foreach($tplData['product'] as $f) {
        $res .="
            <b>$f[nazev]</b><br>";

        //var_dump($tplData['product']);
        //$image = base64_encode($f[foto]->load());
        //res.="<img [src]='data:image/png;base64,'.$image)/>";

        $res .= "<img src='$f[photo]' class='img-fluid' alt='ukazka jidla' width='100' height='100'>";
    }

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
