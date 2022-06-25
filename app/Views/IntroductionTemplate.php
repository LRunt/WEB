<?php

    $tplData['title'] = "Úvodní stránka (TPL)";
    $tplData['stories'] = [array("id_introduction" => 1, "date" => "2016-11-01 10:53:00", "author" => "A.B.", "title" => "Nadpis", "text" => "abcd")];

    define("DIRECTORY_VIEWS", "../Views");

    const WEB_PAGES = array(
        "uvod" => array("title" => "Úvodní stránka (TPL)" )
    );

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    if(array_key_exists('stories', $tplData)){
        foreach ($tplData['stories'] as $d){
            $res .= "<h2>$d[title]</h2>";
            $res .= "<b>Autor:</b> $d[author] (" . date("d. m. Y, H:i.s", strtotime($d['date'])) . ")<br><br>";
            $res .= "<div style='text-align:justify;'><b>Úryvek:</b> $d[text]</div><hr>";
        }
    } else{
        $res .= "Pohádky nenalezeny";
    }
    echo $res;

    $tplHeaders->getHTMLFooter();

?>
