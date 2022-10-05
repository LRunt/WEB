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
                                <option value='none'>Restaurace</option>";
                                foreach ($tplData['products'] as $product){
                                    $res .=     "    <option value=$product[id_produkt]>$product[nazev]</option>";
                                }
              $res .= "     </select>
                        
                            <label class='form-label' for='rating'>Hodnoceni</label>
                            <select name='rating' id='rating' class='form-control'>
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                            </select>
                        
                            <label class='form-label' for='text'>Text recenze</label>
                            <textarea class='form-control' id='text' rows='3'></textarea>   
                            
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
