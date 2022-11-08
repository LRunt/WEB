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
            $res .= "<div class='card-body container-xxl'>
                        <h1>Nová recenze</h1>
              
                        <form action='' method='POST'>
                            <label class='form-label' for='produkt'>Recenze na</label>
                            <select name='product' id='produkt' class='form-control'>
                                <option value='NULL'>Restaurace</option>";
                                foreach ($tplData['products'] as $product){
                                    $res .=     "<option value=$product[id_produkt]>$product[nazev]</option>";
                                }
              $res .= "     </select>
                      
                            <label class='form-label mt-3' for='rating'>Hodnoceni</label><br>
                            <div class='rate' id='rating'> 
                                <input type='radio' id='5' name='rate' value='5' />
                                <label for='5' title='Excelentní'>5 stars</label>
                                <input type='radio' id='4' name='rate' value='4' />
                                <label for='4' title='Výborné'>4 stars</label>
                                <input type='radio' id='3' name='rate' value='3' />
                                <label for='3' title='Dobré'>3 stars</label>
                                <input type='radio' id='2' name='rate' value='2' />
                                <label for='2' title='Průměrné'>2 stars</label>
                                <input type='radio' id='1' name='rate' value='1' />
                                <label for='1' title='Špatné'>1 star</label>
                            </div><br><br>
                        
                            <label class='form-label' for='text'>Text recenze</label>
                            <textarea class='form-control' name='text' id='text' rows='3' required></textarea>   
                            
                            <br>
                            <div class='d-flex justify-content-start'>
                                <input type='submit' name='submit' value='Uložit' class='btn btn-primary btn-lg'>
                            </div>   
                        </form>
                    </div>";
            if($tplData['mode'] == 2){
                $product = $tplData['reviewData']['id_produkt'];
                if($product == null){
                    $product = "NULL";
                }
                $rating = $tplData['reviewData']['hodnoceni'];
                $text = $tplData['reviewData']['popis'];

                $res .= "<script type='text/javascript'>
                             document.getElementById('produkt').value = '$product';
                             document.getElementById('$rating').checked = true;
                             document.getElementById('text').value = '$text';
                        </script>";
            }
        }
    }else{
        $tplHeaders->getInadequateRightsPage();
    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
