<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

$_ = _OWF_MultiID::SetID(['_OWF_TOKEN']);

?>
<p class="form-title font-it">ACCOUNT</p>
<section class="owf-form">
    <input type="text" class="owf-txt font-it" id="owf-email" placeholder="Email">
    <select id="type" class="selection-owf">
        <option value="true">Private</option>
        <option value="false">Public</option>
    </select>
    <input type="password" class="owf-txt font-it" id="owf-pwd" placeholder="Password">
    <button class="owf-btn font-it" id="OWF_FORM_SUBMIT" onclick="
    var work = new ReqJS('<?= Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true); ?>','POST');
    work.setData([
        ['token',document.querySelector('#OWF_TOKEN_WORKER').value],
        ['com','add'],
        ['page','ACCOUNT'],
        ['id',document.querySelector('#owf-email').value],
        ['value',document.querySelector('#owf-pwd').value],
        ['ty',document.querySelector('#type').value]
    ])

    work.send(a => {
        if(a.length > 8){
            document.querySelector('#OWF_TOKEN_WORKER').value = a.substring(0,8);
            download(a.substring(8,a.length),'key.okey','text/plain','OWF_FORM_SUBMIT')
        }
    })

    rester('ACCOUNT','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>',indexPage.innerHTML,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
    linker('ACCOUNT','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true) ?>',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp');
    ">ADD</button>
</section>