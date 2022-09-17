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
            $res .= "<div class='card-body container-xxl'>
                        <h1>Nový produkt</h1>
                        
                        <form action='' method='POST'>
                            <label class='form-label' for='name'>Název</label>
                            <input type='text' id='name' class='form-control' required>
                                                   
                            <label class='form-label' for='photo'>Foto</label><br>
                            <input type='file' id='photo' class='form-control' accept='image/png, image/gif, image/jpeg' required>   
                        
                            <label class='form-label' for='price'>Cena</label>
                            <input class='form-control' id='price' type='text' required>
                            
                            <label class='form-label' for='quantity'>Množství</label>
                            <input class='form-control' id='quantity' type='text' required>
                            
                            <label class='form-label' for='type'>Typ</label>
                            <input class='form-control mb-5' id='type' type='' required>
                            
                            <div class='d-flex justify-content-start'>
                                <input type='submit' name='submit' value='Uložit' class='btn btn-primary btn-lg'>
                            </div>   
                        </form>
                     </div>";
        }else{
            $res .= "<p>Nedostatečná práva!</p>";
        }
    }else{
        $res .= "<p>Nedostatečná práva!</p>";
    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>