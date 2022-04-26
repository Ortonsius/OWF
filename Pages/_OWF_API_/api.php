<?php

class _OWF_API_ extends Control{
    public static function _HideApi(){
        self::Punishment();
    }
    
    public static function _use($fn){
        Importer::import(self::$dir.$fn);
    }

    public static function _getGlob($key){
        return self::get_global($key);
    }
}

_OWF_API_::_use("/Pages/_OWF_API_/api_lib/ApiSec.php");






$token = isset($_POST["Signature"]) ? $_POST["Signature"] : false;
$com = isset($_POST["com"]) ? $_POST["com"] : false;

if($token != false){
    if($token == _OWF_MultiID::GetID("_OWF_TOKEN")){
        if($com != false){
            if($com == "INS_OWF_LOGIN"){
                if(_OWF_AUTH::login()){
                    header("Location: ".Builder::BuildLink("_OWF_PAGES_/main.php",true));
                }else{
                    $_SESSION["_OWF_ACC_BEARER"] = false;
                    $_SESSION["_OWF_ACC_CONTROL"] = false;
                    echo "<script>alert('Invalid login');\n";
                    echo "location.href = '". Builder::BuildLink("_OWF_PAGES_/login.php",true) ."';</script>";
                }
            }
        }else{
            _OWF_API_::_HideApi();
        }
    }else{
        _OWF_API_::_HideApi();
    }
}else{
    _OWF_API_::_HideApi();
}

?>