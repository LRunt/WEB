<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    if(!$tplData['isLogged']){

       $res .=
            "
                <div class='row d-flex align-items-center justify-content-center h-100'>
                  <div class='col-md-8 col-lg-7 col-xl-6'>
                    <img src='data/unlock.svg'
                      class='img-fluid' alt='Phone image'><br>
                  </div>
                  <div class='col-md-7 col-lg-5 col-xl-5 offset-xl-1'>
                    <p class='text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4'>Přihlášení</p>
                    <form action='' method='POST'>
                      <!-- Email input -->
                      <div class='form-outline mb-4'>
                        <input type='text' id='form1Example13' class='form-control form-control-lg' name='username'/>
                        <label class='form-label' for='form1Example13'>Uživatelské jméno</label>
                      </div>
            
                      <!-- Password input -->
                      <div class='form-outline mb-4'>
                        <input type='password' id='form1Example23' class='form-control form-control-lg' name='heslo' />
                        <label class='form-label' for='form1Example23'>Heslo</label>
                      </div>";

                if ($tplData['error']){
                    $res .= "<div class='p-3 mb-2 bg-danger text-white'>$tplData[error]</div>";
                }
            
             $res .= "<div class='d-flex justify-content-around align-items-center mb-4'>
            
                      <!-- Submit button -->
                      <input type='hidden' name='action' value='login'>
                      <input type='submit' class='btn btn-primary btn-lg' name='potvrzeni' value='Přihlásit'>
                      
                      </div>
                      
                      <p class='mb-5 pb-lg-2' style='color: #393f81;'>Nemáš účet? <a href='index.php?page=register'
                        style='color: #393f81;' >Registruj se zde!</a></p>
                    </form>
                  </div>
                </div>";

        /*$res .= " <h2>Přihlášení uživatele</h2>

    <form action='' method='POST'>
        <table>
            <tr><td>Login:</td><td><input type='text' name='username'></td></tr>
            <tr><td>Heslo:</td><td><input type='password' name='heslo'></td></tr>
        </table>
        <input type='hidden' name='action' value='login'>
        <input type='submit' name='potvrzeni' value='Přihlásit'>
        <a href='user-registration.inc.php'>Nemám účet</a>
    </form>";*/
    }else{
        $user = $tplData['user'];
        $res .= "
                 <h2>Přihlášený uživatel</h2>
        <b>Přezdívka:</b> $user[username]<br>
        <b>Email:</b> $user[email]<br>
        <form action='' method='POST'>
            <input type='hidden' name='action' value='logout'>
            <input type='submit' name='potvrzeni' value='Odhlásit' class='btn btn-success mt-2'>
        </form>
        
       <h4 class='mt-3'>Zveřejněné recenze</h4><hr>
        ";
        if(count($tplData['reviews']) == 0){
            $res .= "Zatím jste nezveřejnili žádnou recenzi.";
        }else{
            $i = 1;
            foreach ($tplData['reviews'] as $r){
                $res .= "<b>Rezenze $i</b><br>
                         <style>
                            .checked {
                                color: orange;
                            }
                        </style>";
                $blackStars = 5 - $r['hodnoceni'];
                for($i = 0; $i < $r['hodnoceni']; $i++){
                    $res .= "<span class='fa fa-star checked'></span>";
                }
                for($i = 0; $i < $blackStars; $i++){
                    $res .= "<span class='fa fa-star'></span>";
                }
                $res .="<br>
                         $r[popis]
                         <hr>";
                $i++;
            }

        }
    }

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
