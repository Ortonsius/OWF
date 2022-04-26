<?php
Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

$_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
$_SESSION["_OWF_RES_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
$_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?= Builder::BuildLink("Assets/WHITE_OWF_FAVICON.png",true); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= Builder::BuildLink("_OWF_LIB_/css/global.css"); ?>">
    <link rel="stylesheet" href="<?= Builder::BuildLink("_OWF_LIB_/css/_main_owf.css"); ?>">
    <title>OWF | Station</title>
</head>
<body>
    <input type="hidden" id="OWF_TOKEN_FORM" value="<?= $_SESSION["_OWF_FORM_TOKEN"]; ?>">
    <input type="hidden" id="OWF_TOKEN_RES" value="<?= $_SESSION["_OWF_RES_TOKEN"]; ?>">
    <input type="hidden" id="OWF_TOKEN_WORKER" value="<?= $_SESSION["_OWF_WORKER_TOKEN"]; ?>">
    <section class="controler">
        <div class="cform">
            
        </div>
        <div class="nav">
            <div class="nav-link">
                <div class="center-link">
                    <div class="owf_link font-it">
                        <p>REPORT</p>
                    </div>
                    <div class="owf_link font-it">
                        <p>URL</p>
                    </div>
                    <?php if($_SESSION["_OWF_ACC_CONTROL"]): ?>
                    <div class="owf_link font-it">
                        <p>ACCOUNT</p>
                    </div>
                    <?php endif; ?>
                    <div class="owf_link font-it">
                        <p>FIREWALL</p>
                    </div>
                    <div class="owf_link font-it">
                        <p>SCANNER</p>
                    </div>
                    <div class="owf_link font-it">
                        <p>REGISTRY</p>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <div class="left-page"> < </div>
                <div class="index-page font-it">1</div>
                <div class="right-page"> > </div>
            </div>
        </div>
    </section>
    <section class="res">
        
    </section>
</body>
</html>
<script src="<?= Builder::BuildLink("_OWF_LIB_/js/req.js",true); ?>"></script>
<script src="<?= Builder::BuildLink("_OWF_LIB_/js/_main_owf.js",true); ?>"></script>
<script>
const owfLink = document.querySelectorAll(".owf_link")
const cform = document.querySelector(".cform");
const resPage = document.querySelector(".res");

const indexPage = document.querySelector(".index-page");
const lArrow = document.querySelector(".left-page")
const rArrow = document.querySelector(".right-page")

const formToken = document.querySelector("#OWF_TOKEN_FORM");
const resToken = document.querySelector("#OWF_TOKEN_RES");
const workToken = document.querySelector("#OWF_TOKEN_WORKER");

linker("REPORT","<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true); ?>",formToken,cform);
rester("REPORT","<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>",1,resToken,resPage,indexPage);

owfLink.forEach(a => {
    a.addEventListener("click",() => {
        try{
            indexPage.innerHTML = 1;
            linker(a.querySelector("p").innerHTML,"<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true); ?>",formToken,cform);
            rester(a.querySelector("p").innerHTML,"<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>",1,resToken,resPage,indexPage);
        }catch{
            indexPage.innerHTML = 1;
            window.location.href = window.location.href;
        }
    })
})

rArrow.addEventListener("click",() => {
    indexPage.innerHTML++;
    rester(document.querySelector(".form-title").innerHTML,"<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>",indexPage.innerHTML,resToken,resPage,indexPage);
})

lArrow.addEventListener("click",() => {
    if(indexPage.innerHTML > 1){
        indexPage.innerHTML--;
        rester(document.querySelector(".form-title").innerHTML,"<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>",indexPage.innerHTML,resToken,resPage,indexPage);
    }
})
</script>