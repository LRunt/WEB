<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();
?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    if($tplData['isLogged']){
        if($tplData['weight'] > WEB_PAGES['sprava']['right_weight']){

        }else{
            $res .= "<p>Nedostatečná práva!</p>";
        }
    }else{
        $res .= "<p>Nedostatečná práva!</p>";
    }

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
