<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

if(!isset($_SESSION["_OWF_FORM_TOKEN"])){
    class _HERE_WE_GOO_ extends Control{
        public static function GO(){
            self::Punishment();
        }
    }
    _HERE_WE_GOO_::GO();
    exit();
}

$form = isset($_POST["form"]) ? $_POST["form"] : false;
$token = isset($_POST["token"]) ? $_POST["token"] : false;
$com = isset($_POST["com"]) ? $_POST["com"] : false;
$id = isset($_POST["id"]) ? $_POST["id"] : false;

if($token === $_SESSION["_OWF_FORM_TOKEN"] && $_SESSION["_OWF_FORM_TOKEN"] != false && $_SESSION["_OWF_FORM_TOKEN"] != ""){
    if($form != false){
        class _NOT_ extends Control{
            public static function getJson($loc){
                return self::get_json($loc);
            }

            public static function getGlob($key){
                return self::get_global($key);
            }

            public static function setGlob($key,$value){
                return self::set_global($key,$value);
            }
        }

        if($form == "REPORT"){
            $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
            echo $_SESSION["_OWF_FORM_TOKEN"];
            Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/report.php");
        }else if($form == "ACCOUNT"){
            if($_SESSION["_OWF_ACC_CONTROL"]){
                $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                echo $_SESSION["_OWF_FORM_TOKEN"];
                if($com == "edit" && $id != false){
                    $data = _NOT_::getGlob("Auth");

                    $x = 0;
                    foreach($data as $i){
                        if($i[2] == $id){
                            break;
                        }else{
                            $x++;
                        }
                    }

                    echo "<p class=\"form-title font-it\">ACCOUNT</p>
                    <section class=\"owf-form\">
                        <input type=\"hidden\" id=\"owf-id\" value=\"$id\">
                        <input type=\"text\" class=\"owf-txt font-it\" id=\"owf-email\" placeholder=\"Email\" value=\"".$data[$x][5]."\">
                        <select id=\"type\">
                            <option value=\"true\">Private</option>
                            <option value=\"false\">Public</option>
                        </select>
                        <input type=\"password\" class=\"owf-txt font-it\" id=\"owf-pwd\" placeholder=\"Password\" value=\"".$data[$x][1]."\">
                        <button class=\"owf-btn font-it\" id=\"OWF_FORM_SUBMIT\" onclick=\"
                        workster(
                            '".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true) ."',
                            document.querySelector('#OWF_TOKEN_WORKER'),
                            'edit',
                            'ACCOUNT',
                            document.querySelector('#owf-email').value,
                            [
                                ['value',document.querySelector('#owf-pwd').value],
                                ['ty',document.querySelector('#type').value],
                                ['pc',document.querySelector('#owf-id').value]]
                            );
                        rester('ACCOUNT','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true) ."',indexPage.innerHTML,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                        linker('ACCOUNT','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')\">EDIT</button>
                    </section>";
                }else{
                    Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/account.php");
                }
            }
        }else if($form == "URL"){
            $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
            echo $_SESSION["_OWF_FORM_TOKEN"];
            Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/url.php");
        }else if($form == "FIREWALL"){
            $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
            echo $_SESSION["_OWF_FORM_TOKEN"];
            Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/firewall.php");
        }else if($form == "SCANNER"){
            $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
            echo $_SESSION["_OWF_FORM_TOKEN"];
            Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/scanner.php");
        }else if($form == "REGISTRY"){
            $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
            echo $_SESSION["_OWF_FORM_TOKEN"];
            if($com == "edit" && $id != false){
                $data = _NOT_::getJson(Control::$dir."/data/global.json");
                if(isset($data[$id])){
                    echo "<p class=\"form-title font-it\">REGISTRY</p>
                    <section class=\"owf-form\">
                    <input type=\"text\" class=\"owf-txt font-it\" id=\"owf-key\" placeholder=\"Key\" disabled='true' value=\"$id\">
                    <input type=\"text\" class=\"owf-txt font-it\" id=\"owf-value\" placeholder=\"Value\" value=\"".(gettype($data[$id]) == "array" ? "[Object]" : $data[$id])."\">
                    <button class=\"owf-btn font-it\" id=\"OWF_FORM_SUBMIT\" onclick=\"
                        workster('". Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true) ."',document.querySelector('#OWF_TOKEN_WORKER'),'edit','REGISTRY',document.querySelector('#owf-key').value,[['value',document.querySelector('#owf-value').value]]);
                        linker('REGISTRY','". Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true) ."',document.querySelector('#OWF_TOKEN_FORM'),cform);
                        rester('REGISTRY','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',document.querySelector('.index-page').innerHTML,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage)\">EDIT</button>
                    </section>";
                }
            }else{
                Importer::import(Control::$dir."/Pages/_OWF_PAGES_/_OWF_FORM_/registry.php");
            }
        }
    }else{
        $_SESSION["_OWF_FORM_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
    }
}else{
    echo "false";
}

?>