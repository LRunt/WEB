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

        $res.="<img [src]='data:image/png;base64,base64_encode($f[foto])'/>";
    }

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
