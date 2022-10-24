<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

        $res = "
                          <div class='card-body p-md-5'>
                            <div class='row justify-content-center'>
                               <div class='col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-1'>
                
                                <img src='data/register-picture.jpg'
                                  class='img-fluid' alt='Sample image'>
                
                              </div>
                              <div class='col-md-10 col-lg-6 col-xl-5 order-2 order-lg-2'>
                
                                <p class='text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4'>Registrace</p>
                
                                <form class='mx-1 mx-md-4' action='' method='POST' oninput='x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla''>
                
                                  <div class='d-flex flex-row align-items-center mb-4'>
                                    <i class='fas fa-user fa-lg me-3 fa-fw'></i>
                                    <div class='form-outline flex-fill mb-0'>
                                      <input type='text' id='form3Example1c' class='form-control' name='username' value='$tplData[username]' required/>
                                      <label class='form-label' for='form3Example1c'>Přezdívka</label>
                                    </div>
                                  </div>
                
                                  <div class='d-flex flex-row align-items-center mb-4'>
                                    <i class='fas fa-envelope fa-lg me-3 fa-fw'></i>
                                    <div class='form-outline flex-fill mb-0'>
                                      <input type='email' id='form3Example3c' class='form-control' name='email' value='$tplData[email]' required/>
                                      <label class='form-label' for='form3Example3c'>Email</label>
                                    </div>
                                  </div>
                
                                  <div class='d-flex flex-row align-items-center mb-4'>
                                    <i class='fas fa-lock fa-lg me-3 fa-fw'></i>
                                    <div class='form-outline flex-fill mb-0'>
                                      <input type='password' id='form3Example4c' class='form-control' name='heslo' id='pas1' value='$tplData[password]' required/>
                                      <label class='form-label' for='form3Example4c'>Heslo</label>
                                    </div>
                                  </div>
                
                                  <div class='d-flex flex-row align-items-center mb-4'>
                                    <i class='fas fa-key fa-lg me-3 fa-fw'></i>
                                    <div class='form-outline flex-fill mb-0'>
                                      <input type='password' id='form3E+xample4cd' class='form-control' name='heslo2' id='pas2' value='$tplData[password2]' required/>
                                      <label class='form-label' for='form3Example4cd'>Heslo (znovu)</label>
                                    </div>
                                  </div>
                
                                  <div class='form-check d-flex justify-content-center mb-2'>
                                    <input class='form-check-input me-2' type='checkbox' class='form-control' name='souhlas' id='form2Example3c' />
                                    <label class='form-check-label' for='form2Example3'>
                                      Souhlasím se všemi <a href='http://localhost/WEB/index.php?page=policy'>Podmínkami užití</a>
                                    </label>
                                  </div>";

                    if($tplData['error']){
                        $res .= "<div class='p-3 mb-2 bg-danger text-white'>$tplData[error]</div>";
                    }

        $res .= "                <div class='d-flex justify-content-center mx-4 mb-3 mb-lg-4'>
                                    <input type='submit' name='potvrzeni' value='Registrovat' class='btn btn-primary btn-lg'>
                                  </div>
                                </form>
                
                              </div>
                            </div>
                          </div>";

    /*$res .=" <h2>Registrační formulář</h2>
                <form action='' method='POST' oninput='x.value=(pas1.value==pas2.value)?'OK':'Nestejná hesla''>
                    <table>
                        <tr><td>Přezdívka:</td><td><input type='text' name='username' required></td></tr>
                        <tr><td>E-mail:</td><td><input type='email' name='email' required></td></tr>
                        <tr><td>Heslo:</td><td><input type='password' name='heslo' id='pas1' required></td></tr>
                        <tr><td>Heslo (znovu):</td><td><input type='password' name='heslo2' id='pas2' required></td></tr>
                    </table>
                    <input type='submit' name='potvrzeni' value='Registrovat'>
                    </form>";*/

    echo $res;

    $tplHeaders->getHTMLFooter();

?>
