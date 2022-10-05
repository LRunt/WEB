<?php

/**
 * Class Creating header and footer of the page
 */
class TemplateBasics{

    public function getInadequateRightsPage(){
        ?>

        <h1 class="text-center"><b>Nedostatečná práva!</b></h1>
        <p class="text-center">Pokud chcete vidět obsah stránky, budete se muset přihlásit.</p>
        <div class="text-center">
            <img src='data/inadequateRights.svg' width="600" class='img-fluid' alt='Bad rights'>
        </div>

        <?php
    }

    /**
     * Returns a headre of the page
     * @param string $pageTitle name of the page
     */
    public function getHTMLHeader(string $pageTitle){

        global $tplData;

        ?>

    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Semestralni prace - Restaurace U Rybnicka">
        <meta name="keywords" content="Restaurace">
        <meta name="author" content="Lukas Runt">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <title><?php echo $pageTitle;?></title>

    </head>
    <body>
    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img class="bi me-2" width="40" height="32" role="img" aria-label="Restaurace" src="data/logo.png">
                </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <?php
                            foreach(WEB_PAGES as $key => $pInfo){
                                if($key!='login' && $key!='register'){
                                    $weight_of_rights = 0;
                                    if($tplData['isLogged']){
                                        $weight_of_rights = $tplData['weight'];
                                    }
                                    if($weight_of_rights >= $pInfo['right_weight']){
                                        echo "<li><a class='nav-link px-2 text-white' href='index.php?page=$key'>$pInfo[title]</a></li>";
                                    }
                                }
                            }
                        ?>
                    </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search..." aria-label="Search">
                </form>

                <?php if(!$tplData['isLogged']){
                ?>
                <div class="text-end">
                    <a type="button" class="btn btn-outline-light me-2" href="index.php?page=login">Login</a>
                    <a type="button" class="btn btn-warning" href="index.php?page=register">Sign-up</a>
                </div>
                <?php
                }else{
                ?>
                <div class="text-end">
                    <a type="button" class="btn btn-outline-light me-2" href="index.php?page=login"><?php echo $tplData['user']['username']?></a>
                    <form action='' method='POST' class="btn">
                        <input type='hidden' name='action' value='logout'>
                        <input class="btn btn-warning" type='submit' name='potvrzeni' value='Odhlásit'>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </header>

     <main style="margin: 50px">
        <!-- START THE FEATURETTES -->
        <div class="container marketing">

    <?php
    }

    /**
     * Return footer of the page
     */
    public function getHTMLFooter(){
        ?>
            </div>
        </main>
        <br>
        <!-- Footer -->
        <footer class="text-center text-lg-start bg-light text-muted">
            <!-- Section: Social media -->
            <section class="mb-4">
                <div class="text-center">
                    <!-- Facebook -->
                    <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="https://www.facebook.com/profile.php?id=100005716547788" role="button"><i class="fab fa-facebook-f"></i></a>

                    <!-- Google -->
                    <a class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39" href="https://www.youtube.com/channel/UCGWseNsfVppIVLu9xhMdL0Q" role="button"><i class="fab fa-youtube"></i></a>

                    <!-- Instagram -->
                    <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="https://www.instagram.com/lukas_runt/" role="button"><i class="fab fa-instagram"></i></a>

                    <!-- Github -->
                    <a class="btn btn-primary btn-floating m-1" style="background-color: #333333" href="https://github.com/LRunt" role="button"><i class="fab fa-github"></i></a>
                </div>
            </section>
            <!-- Section: Social media -->

            <!-- Section: Links  -->
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <!-- Grid row -->
                    <div class="row mt-3">
                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <!-- Content -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                <i class="fas fa-utensils me-3"></i>Restaurace U Rybníčka
                            </h6>
                            <p>
                                Ubytování, Volnočasové aktivity, Svatby a oslavy.
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Disponujeme
                            </h6>
                            <p>
                                Velký Sál
                            </p>
                            <p>
                                Bowling
                            </p>
                            <p>
                                Konferenční salónek
                            </p>
                            <p>
                                Restaurace
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Navštivte také
                            </h6>
                            <p>
                                <a href="https://www.obecbrezno.cz/" class="text-reset">Obec Březno</a>
                            </p>
                            <p>
                                <a href="https://www.sd-infocentrum.cz/pribeh/brezensky-drak/o-drakovi.aspx" class="text-reset">Drak Severus</a>
                            </p>
                            <p>
                                <a href="https://restauraceurybnicka.webnode.cz/ubytovani/" class="text-reset">Restaurace</a>
                            </p>
                            <p>
                                <a href="https://www.kulturnidumbrezno.cz/" class="text-reset">Kulturní dům</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold mb-4">
                                Kontakt
                            </h6>
                            <p><i class ="fas fa-address-book me-3"></i>Lukáš Runt</p>
                            <p><i class="fas fa-home me-3"></i>Zahradní 347, Březno, 431 45</p>
                            <p><i class="fas fa-envelope me-3"></i>lrunt@students.zcu.cz</p>
                            <p><i class="fas fa-phone me-3"></i>+420 606 320 412</p>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
            </section>
            <!-- Section: Links  -->

            <!-- Copyright -->
            <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2021 Copyright:
                <a class="text-reset fw-bold" href="https://github.com/LRunt">Lukas Runt</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->

        <?php

    }
}

?>