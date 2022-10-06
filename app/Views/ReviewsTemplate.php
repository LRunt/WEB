<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";
    foreach($tplData['reviews'] as $review){
        if($review['zverejneno'] >= 1){
            $username = "";
            $productName = "";
            foreach ($tplData['users'] as $user){
                if($user['id_uzivatel'] == $review['id_uzivatel']){
                    $username = $user['username'];
                }
            }
            foreach ($tplData['products'] as $product){
                if($product['id_produkt'] == $review['id_produkt']){
                    $productName = $product['nazev'];
                }
            }
            $res .=" <div>
                        <h5><b><u>$username</u></b></h5>
                        <h6><b>Produkt:</b> $productName</h6>
                        <style>
                            .checked {
                                color: orange;
                            }
                        </style>";
            $blackStars = 5 - $review['hodnoceni'];
            for($i = 0; $i < $review['hodnoceni']; $i++){
                $res .= "<span class='fa fa-star checked'></span>";
            }
            for($i = 0; $i < $blackStars; $i++){
                $res .= "<span class='fa fa-star'></span>";
            }
            $res .="    <p>$review[popis]</p>";
            if($tplData['isLogged']){
                if($tplData['user']['id_pravo'] <= 2){
                    $res .= "<button>Zveřejni</button>";
                }
            }
            $res .= "  <hr></div>";
        }

    }
    echo $res;

    $tplHeaders->getHTMLFooter();

?>
