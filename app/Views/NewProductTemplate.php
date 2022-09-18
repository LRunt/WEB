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
                        
                        <form action='' method='POST' enctype='multipart/form-data'>
                            <label class='form-label' for='name'>Název</label>
                            <input type='text' id='name' class='form-control' name='name' required>
                                                   
                            <label class='form-label' for='photo'>Foto</label><br>
                            <input type='file' id='photo' class='form-control' name='photo' accept='image/png, image/gif, image/jpeg' value='' required>   
                        
                            <label class='form-label' for='price'>Cena</label>
                            <input class='form-control' id='price' type='number' name='price' min='0' required>
                            
                            <label class='form-label' for='quantity'>Množství</label>
                            <input class='form-control' id='quantity' type='text' name='quantity' required>
                            
                            <label class='form-label' for='type'>Typ</label>
                            <select name='type' id='type' class='form-control' required>";
                                foreach ($tplData['typesOfProducts'] as $type){
                                    $res .= "<option value=$type[id_typ]>$type[nazev]</option>";
                                }
            $res .=        "</select>
                            
                            <br>
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
