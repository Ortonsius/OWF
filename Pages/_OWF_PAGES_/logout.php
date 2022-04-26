<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::logout();
header("Location: ".Builder::BuildLink("_OWF_PAGES_/login.php",true));

?>