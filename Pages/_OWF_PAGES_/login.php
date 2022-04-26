<?php
Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::logout();

$sn = ["_OWF_TOKEN","_OWF_LOGIN_AUTHKEY","_OWF_LOGIN_PASSCODE"];
$new_token = _OWF_MultiID::SetID($sn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?= Builder::BuildLink("Assets/WHITE_OWF_FAVICON.png",true); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= Builder::BuildLink('_OWF_LIB_/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= Builder::BuildLink('_OWF_LIB_/css/_login_owf.css'); ?>">
    <title>OWF | Login</title>
</head>
<body>
    <form method="POST" action="<?= Builder::BuildLink("_OWF_API_/api.php",true); ?>" enctype="multipart/form-data">
    <input type="hidden" name="Signature" value="<?= $new_token[0]; ?>">
    <input type="hidden" name="com" value="INS_OWF_LOGIN">
        <section class="top font-it">
            <div class="key-class">
                <p>KEY</p>
                <input type="file" accept=".okey" class="auth-key" name="<?= $_SESSION["_OWF_LOGIN_AUTHKEY"]; ?>">
            </div>
            <div class="passcode-class">
                <input type="password" placeholder="PASSCODE" class="passcode" name="<?= $_SESSION["_OWF_LOGIN_PASSCODE"]; ?>">
            </div>
        </section>
        <section class="bottom font-it">
            <p>LOGIN</p>
            <button></button>
        </section>
    </form>
</body>
</html>
<script src="<?= Builder::BuildLink('_OWF_LIB_/js/_login_owf.js'); ?>"></script>