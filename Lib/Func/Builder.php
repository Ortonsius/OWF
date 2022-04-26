<?php

class Builder extends Control{
    public static function BuildLink($fn,$ret=false){
        $dir = self::$dir."/Data/pages.json";
        $data = self::get_json($dir);
        foreach($data as $_ => $v){
            if($v["loc"] == $fn){
                if($ret){
                    return str_replace("'","",str_replace("\"","",$v["url"]));
                }else{
                    echo str_replace("'","",str_replace("\"","",$v["url"]));
                    break;
                }
            }
        }
    }

    public static function CreateGateID($name){
        $id = self::randstr(6,"!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?1234567890");
        $_SESSION[$name] = $id;
        return $id;
    }
}

?>