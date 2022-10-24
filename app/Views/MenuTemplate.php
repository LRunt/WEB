<?php

    global $tplData;

    require_once(DIRECTORY_VIEWS."/TemplateBasics.php");
    $tplHeaders = new TemplateBasics();

?>
<?php

    $tplHeaders->getHTMLHeader($tplData['title']);

    $res = "<div class='row d-flex align-items-start justify-content-start h-100'>
<h1>Jídelní lístek</h1>";

    foreach($tplData['product'] as $f) {
        $res .="
            <h6><b>$f[nazev]</b></h6><br>";

        $res .= "
             <div style='width: 150px; float:left; margin:10px'>
                <img src='$f[photo]' class='img-fluid' alt='ukazka jidla' width='200' height='100'>
             </div>
             <div style='width: 45%; float:left; margin:10px'>
                <b>Cena: </b> $f[cena]Kč<br>
                <b>Množství: </b> $f[mnozstvi]
             </div>
             <hr>
            ";
    }

    $res .= "
    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>
  Launch demo modal
</button>

<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        ...
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button type='button' class='btn btn-primary'>Save changes</button>
      </div>
    </div>
  </div>
</div>

    ";

    $res .='</div>';

    echo $res;

    $tplHeaders->getHTMLFooter();
?>
