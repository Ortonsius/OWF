<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

?>
<p class="form-title font-it">FIREWALL</p>
<section class="owf-form">
    <input type="text" class="owf-txt font-it" id="owf-fwname" placeholder="Name">
    <div class="upl-owf">
        <input type="file" class="owf-file font-it" id="owf-fw" onchange="document.querySelector('.upl-owf p').innerHTML = 'File included';">
        <p class="font-it">Upload file...</p>
    </div>
    <button class="owf-btn font-it" id="OWF_FORM_SUBMIT" onclick="
    workster('<?= Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true); ?>',document.querySelector('#OWF_TOKEN_WORKER'),'add','FIREWALL',document.querySelector('#owf-fwname').value,[['owf-fw-file',document.querySelector('#owf-fw').files[0]]]);
    rester('FIREWALL','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>',indexPage.innerHTML,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
    linker('FIREWALL','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true) ?>',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')">ADD</button>
</section>
<script>

document.querySelector(".upl-owf input").addEventListener("change",() => {
    
})
</script>