<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

?>
<p class="form-title font-it">SCANNER</p>
<section class="owf-form">
    <div class="upl-owf">
        <input type="file" class="owf-file font-it" id="owf-fw" onchange="document.querySelector('.upl-owf p').innerHTML = 'File included';">
        <p class="font-it">Upload file...</p>
    </div>
    <button class="owf-btn font-it" id="OWF_FORM_SUBMIT" onclick="
    workster('<?= Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true); ?>',document.querySelector('#OWF_TOKEN_WORKER'),'add','SCANNER','',[['owf-sc-file',document.querySelector('#owf-fw').files[0]]]);
    rester('SCANNER','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>',indexPage.innerHTML,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
    linker('SCANNER','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true) ?>',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')">ADD</button>
</section>