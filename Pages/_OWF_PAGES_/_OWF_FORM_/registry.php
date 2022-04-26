<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

?>
<p class="form-title font-it">REGISTRY</p>
<section class="owf-form">
    <input type="text" class="owf-txt font-it" id="owf-key" placeholder="Key">
    <input type="text" class="owf-txt font-it" id="owf-value" placeholder="Value">
    <button class="owf-btn font-it" id="OWF_FORM_SUBMIT" onclick="workster('<?= Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true); ?>',document.querySelector('#OWF_TOKEN_WORKER'),'add','REGISTRY',document.querySelector('#owf-key').value,[['value',document.querySelector('#owf-value').value]]);
    linker('REGISTRY','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true); ?>',document.querySelector('#OWF_TOKEN_FORM'),cform);
    rester('REGISTRY','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>',indexPage.innerHTML,resToken,resPage,indexPage)">ADD</button>
</section>