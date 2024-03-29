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
        if($tplData['weight'] > WEB_PAGES['sprava']['right_weight']){
            $res .= "<h1>Seznam uživatelů</h1>
            <div class='table-responsive'>
            <table class='table align-middle mb-0 bg-white'>
                <thead class='bg-light'>
                    <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Právo</th>
                    <th>Smazání</th>
                    </tr>
                </thead><tbody>";

            //<table border='1'><tr><th>ID</th><th>Username</th><th>E-mail</th><th>Právo</th><th>Smazat</th></tr>";
            // projdu data a vypisu radky tabulky
            foreach($tplData['users'] as $u) {
                /*$res .= "<tr><td>$u[id_uzivatel]</td><td>$u[username]</td><td>$u[email]</td><td>$u[id_pravo]</td>"
                                ."<td><form method='post'>"
                                        ."<input type='hidden' name='id_user' value='$u[id_uzivatel]'>"
                                        ."<button type='submit' name='action' value='delete'>Smazat</button>"
                                        ."</form></td></tr>";
                            }*/
                $res .= "
            <tr>
            <th scope='row'>$u[id_uzivatel]</th>
            <td>$u[username]</td>
            <td>$u[email]</td>
            <td>
            <form method='POST' action=''>
                <input type='hidden' name='id_user' value='$u[id_uzivatel]'>
                <select name ='pravo' onchange='this.form.submit()'>";
                foreach($tplData['rights'] as $r){
                    $selected = ($r['id_pravo'] == $u['id_pravo']) ? "selected" : "";
                    $res .=" <option value=$r[id_pravo] $selected>$r[nazev]</option>";
                }
                $res .= "</select></form></td>
                <td>
                    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal$u[id_uzivatel]'>Smazat</button>
                    <div class='modal fade' id='exampleModal$u[id_uzivatel]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Smazání uživatele</h5>
                          </div>
                          <div class='modal-body'>
                            Opravdu chcete smazat uživatele <b>$u[username]</b>?
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-primary' data-dismiss='modal'>Zrušit</button>
                            <form method='post'>
                                 <input type='hidden' name='id_user' value='$u[id_uzivatel]'>
                                 <button type='submit' class='btn btn-danger' name='action' value='delete'>Smazat</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
            </tr>";
            }
            $res .= "    </tbody>
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
