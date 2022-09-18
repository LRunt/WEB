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
            $res .= "<h1>Seznam produktů</h1>
                        <div class='row'>
                            <div class='col-md-12 my-2'>
                                <form method='post'>
                                    <input type='hidden' name='newProduct' value=''>
                                    <button type='submit' class='btn btn-primary float-end' name='action' value='newProduct'>Nový produkt</button>
                                </form>
                            </div>
                        </div>
                       
                        <div class='table-responsive'>
                        <table class='table align-middle mb-0 bg-white'>
                            <thead class='bg-light'>
                            <tr>
                            <th>Pokrm</th>
                            <th>Cena</th>
                            <th>Množství</th>
                            <th>Uprav</th> 
                            <th>Smaž</th>  
                            </tr>
                        </thead><tbody>";
            foreach ($tplData['products'] as $product){
                $res .="<tr>
                    <th scope='row'>$product[nazev]</th>
                    <td>$product[cena] Kč</td>
                    <td>$product[mnozstvi]</td>
                    <td><button>Uprav</button></td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='id_produkt' value='$product[id_produkt]'>
                            <button type='submit' class='btn btn-danger' name='action' value='delete'>Smaž</button>
                        </form>        
                    </td></tr>";
            }
            $res .= "</tbody>
                    </table>
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
