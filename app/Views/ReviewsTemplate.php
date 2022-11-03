<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "<h1>Recenze</h1>";
    if($tplData['isLogged']){
        $res .= "
                <div>
                    <form method='post'>
                        <input type='hidden' name='newReview' value=''>
                        <button type='submit' class='btn btn-primary float-end' name='action' value='newReview'>Napsat recenzi</button>
                    </form>
                </div>    
                ";
    }
    foreach($tplData['reviews'] as $review){
        $date = strtotime($review['datum']);
        $formattedDate = date('d. m. Y H:i', $date);
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
            $res .= " <div>
                        <h5><b><u>$username</u></b></h5>
                        <h6><b>$productName</b></h6>
                        $formattedDate<br>
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
                    $res .= "<p><b>Stav:</b> Veřejné</p>
                            <form action='' method='POST'>
                                <input type='hidden' name='id_review' value=$review[id_recenze]>
                                <button type='submit' name='action' class='btn btn-secondary' style='width: 150px' value='hide'>Skrýt</button>
                                 
                               <button type='button' class='btn btn-danger' style='width: 150px' data-toggle='modal' data-target='#delete$review[id_recenze]'>Smazat</button>
                                <div class='modal fade' id='delete$review[id_recenze]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Smazání recenze</h5>
                                      </div>
                                      <div class='modal-body'>
                                        Opravdu chcete smazat recenzi:<br><b>$review[popis]</b>?
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-primary' data-dismiss='modal'>Zrušit</button>
                                             <input type='hidden' name='id_review_delete' value='$review[id_recenze]'>
                                             <button type='submit' class='btn btn-danger' name='action' value='delete'>Smazat</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </form>";
                }
            }
            $res .= "  <hr></div>";
        }else{
            if($tplData['isLogged']){
                if($tplData['user']['id_pravo'] <= 2){
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
                        <h6><b>$productName</b></h6>
                        $formattedDate<br>
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
                    $res .="    <p>$review[popis]</p>
                            <p><b>Stav:</b> Neveřejné</p>
                            <form action='' method='POST'>
                                <input type='hidden' name='id_review' value=$review[id_recenze]>
                                <button type='submit' class='btn btn-success' name='action' style='width: 150px' value='publish'>Zveřejnit</button>

                                 <button type='button' class='btn btn-danger' style='width: 150px' data-toggle='modal' data-target='#delete$review[id_recenze]'>Smazat</button>
                                <div class='modal fade' id='delete$review[id_recenze]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Smazání recenze</h5>
                                      </div>
                                      <div class='modal-body'>
                                        Opravdu chcete smazat recenzi:<br><b>$review[popis]</b>?
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-primary' data-dismiss='modal'>Zrušit</button>
                                             <input type='hidden' name='id_review_delete' value='$review[id_recenze]'>
                                             <button type='submit' class='btn btn-danger' name='action' value='delete'>Smazat</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </form>
                            <hr></div>";
                }
            }
        }

    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
