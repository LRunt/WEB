<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();
?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    if(isset($tplData['delete']) && isset($tplData['success'])){
        if($tplData['success'] == "OK"){
            echo "<div class='alert alert-success d-flex align-items-center' role='alert'>
                    <i class='fa fa-check' aria-hidden='true'></i>
                    <div class='ms-2'>
                       $tplData[delete]
                    </div>
                 </div>";
        } else if($tplData['success'] == "ERROR"){
            echo "<div class='alert alert-danger d-flex align-items-center' role='alert'>
                    <i class='fa fa-times' aria-hidden='true'></i>
                    <div class='ms-2'>
                       $tplData[delete]
                    </div>
               </div>";
        } else if($tplData['success'] == "WARNING"){
            echo "<div class='alert alert-warning d-flex align-items-center' role='alert'>
                    <i class='fa fa-exclamation-triangle' aria-hidden='true'></i>
                    <div class='ms-2'>
                       $tplData[delete]
                    </div>
               </div>";
        }
    }

    $res = "";

    if($tplData['isLogged']){
        if($tplData['weight'] >= WEB_PAGES['productManagement']['right_weight']){
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
                            <th>Smaž</th>  
                            </tr>
                        </thead><tbody>";
            foreach ($tplData['products'] as $product){
                $res .="<tr>
                    <th scope='row'>$product[nazev]</th>
                    <td>$product[cena]Kč</td>
                    <td>$product[mnozstvi]</td>
                    <td>
                      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal$product[id_produkt]'>Smazat</button>
                        <div class='modal fade' id='exampleModal$product[id_produkt]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                          <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Smazání produktu</h5>
                              </div>
                              <div class='modal-body'>
                                Opravdu chcete smazat produkt <b>$product[nazev]</b>?
                              </div>
                              <div class='modal-footer'>
                                <button type='button' class='btn btn-primary' data-dismiss='modal'>Zrušit</button>
                                <form method='post'>
                                      <input type='hidden' name='id_produkt' value='$product[id_produkt]'>
                                      <button type='submit' class='btn btn-danger' name='action' value='delete'>Smazat</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>        
                    </td></tr>";
            }
            $res .= "</tbody>
                    </table>
                    </div>";

        }else{
            $tplHeaders->getInadequateRightsPage();
        }
    }else{
        $tplHeaders->getInadequateRightsPage();
    }

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
