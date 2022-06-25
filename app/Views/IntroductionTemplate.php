<?php

  global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>

<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "";

    $res .="    <div class='row featurette'>
                    <div class='col-md-7'>
                        <h1 class='featurette-heading fw-normal lh-1'>Vítejte na stránkách Restaurace u Rybníčka</h1>
                        <p class='lead'>Naše restaurace U Rybíčka se nachází v obci Březno nedaleko Chomutova. jsme zaměřeni na stravovací služby, denně vaříme teplá jídla. Máme k dispozici hlavní místnost s kapacitou 40 míst, dále nekuřácký salónek s kapacitou 15 míst pro menší oslavy. V letním období i terasu s kapacitou 40 míst. Součástí resturace je i obecní sál o kapacitě 150 míst. V letním období je využíván rybníček ke koupání. Dále je k dispozici nově vybudovaný plážový volejbal i tenisový kurt.</p>
                        <a class='text-reset fw-bold' href='user-management.inc.php'>DEBUG</a>
                    </div>
                    <div class='col-md-5'>
                        <img class='bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto' width='500' height='500' src='data/Restaurace.jpg' role='img' aria-label='Placeholder: 500x500' preserveAspectRatio='xMidYMid slice' focusable='false'><title>Obrázek restaurace</title><rect width='100%' height='100%' fill='#eee'/></img>
                    </div>
                </div>";
    
    echo $res;

    $tplHeaders->getHTMLFooter();

?>
