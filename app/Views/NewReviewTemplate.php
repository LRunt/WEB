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
                                    $res .=     "    <option value=$product[id_produkt]>$product[nazev]</option>";
                                }
              $res .= "     </select>
                        
                           
                            <!--<select name='rating' id='rating' class='form-control'>
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                            </select>-->
                            <label class='form-label mt-3' for='rating'>Hodnoceni</label><br>
                            <div class='rate' id='rating'> 
                                <input type='radio' id='star5' name='rate' value='5' />
                                <label for='star5' title='Excelentní'>5 stars</label>
                                <input type='radio' id='star4' name='rate' value='4' />
                                <label for='star4' title='Výborné'>4 stars</label>
                                <input type='radio' id='star3' name='rate' value='3' />
                                <label for='star3' title='Dobré'>3 stars</label>
                                <input type='radio' id='star2' name='rate' value='2' />
                                <label for='star2' title='Průměrné'>2 stars</label>
                                <input type='radio' id='star1' name='rate' value='1' />
                                <label for='star1' title='Špatné'>1 star</label>
                            </div><br><br>
                        
                            <label class='form-label' for='text'>Text recenze</label>
                            <textarea class='form-control' name='text' id='text' rows='3' required></textarea>   
                            
                            <br>
                            <div class='d-flex justify-content-start'>
                                <input type='submit' name='submit' value='Uložit' class='btn btn-primary btn-lg'>
                            </div>   
                        </form>
                    </div>";
        }
    }else{
        $tplHeaders->getInadequateRightsPage();
    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
