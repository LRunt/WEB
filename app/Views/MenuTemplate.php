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

        var_dump($tplData['product']);

        /*while($row = $f['foto']->fetch_assoc()){
            $res.="<img src='data:image/jpg;charset=utf8;base64,'/>";
        }*/
    }

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
