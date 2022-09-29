<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    if($tplData['isLogged']){
        if($tplData['weight'] > WEB_PAGES['newReview']['right_weight']){

        }
    }else{
        $tplHeaders->getInadequateRightsPage();
    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
