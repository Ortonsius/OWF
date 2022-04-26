<?php

class Control{
    public static $dir;

    private static $glob = "/Data/global.json";
    private static $page = "/Data/pages.json";
    private static $error = "/Data/error.json";

    public static function root($loc){
        self::$dir = $loc;
    }

    public static function strcon($str,$sch){
        $strlen = strlen($str);
        $schlen = strlen($sch);

        $x = 0;

        for($i = 0; $i < $strlen; $i++){
            if($str[$i] == $sch[$x]){
                if($x >= $schlen - 1){
                    return true;
                }else{
                    $x++;
                }
            }else{
                $x = 0;
            }
        }

        return false;
    }

    public static function randstr($len,$except=""){
        $char = "1234567890qwertyuiopasdfghjklzxcvbnmQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?";
        $clen = strlen($char) - 1;
        $str = "";
        for($i = 0; $i < $len; $i++){
            $nc = $char[mt_rand(0,$clen)];
            if($except != ""){
                while(self::strcon($except,$nc)){
                    $nc = $char[mt_rand(0,$clen)];
                }
            }

            $str .= $nc;
        }
        return $str;
    }

    protected static function get_json($loc){
        return json_decode(file_get_contents($loc),true);
    }

    protected static function set_json($loc,$data){
        file_put_contents($loc,json_encode($data));
    }

    protected static function set_global($key,$value){
        $data = self::get_json(self::$dir.self::$glob);
        $data[$key] = $value;
        self::set_json(self::$dir.self::$glob,$data);
    }
    
    protected static function get_global($key){
        $data = self::get_json(self::$dir.self::$glob);
        foreach($data as $k => $v){
            if($k == $key){
                return $v;
            }
        }

        return NULL;
    }

    protected static function get_page(){
        return self::get_json(self::$dir.self::$page);
    }

    protected static function log_error($msg,$type){
        $data = self::get_json(self::$dir.self::$error);
        $GID = "";
        if($data == "" || $data == NULL){
            $GID = "ERROR-1";
        }else{
            $c = count($data) + 1;
            $GID = "ERROR-".strval($c);
        }

        $now = date("Y:m:d H:i:s");
        $url = $_SERVER["REQUEST_URI"];
        $ip = $_SERVER["REMOTE_ADDR"];

        $data[$GID] = [
            "type" => $type,
            "url" => $url,
            "ip" => $ip,
            "date" => $now,
            "msg" => $msg
        ];

        self::set_json(self::$dir.self::$error,$data);
    }

    protected static function get_fwl(){
        $data = self::get_json(self::$dir."/Data/firewall_ls.json");
        $ret = [];
        foreach($data as $k => $v){
            array_push($ret,[$k,$v]);
        }
        return $ret;
    }


    protected static function set_report($desc,$type,$url){
        $data = self::get_json(self::$dir."/Data/alert.json");
        if($data == ""){
            $id = "ALERT-".self::randstr(6,"\\\"\'<>.#");
        }else{
            $id = "ALERT-".self::randstr(6,"\\\"\'<>.#");
            while(isset($data[$id])) $id = "ALERT-".self::randstr(6,"\\\"\'<>.#");
        }

        $data[$id] = [
            "date" => date("Y-m-d H:i:s"),
            "desc" => $desc,
            "ip" => $_SERVER["REMOTE_ADDR"],
            "url" => $url,
            "type" => $type
        ];

        self::set_json(self::$dir."/Data/alert.json",$data);
    }

    protected static function Punishment(){
        if(self::get_global("is_prank")){
            $link = self::get_global("prank_link");
            $l = $link[mt_rand(0,count($link))];
            header("Location: $l");
            exit();
        }else{
            include_once self::$dir.'/Pages/404.php';
            exit();
        }
    }

    public static function FileMove($f,$dst,$ext,$skip=false){
        $danger = [];
        // DEST NAME, ORI NAME, msg
        if($f["error"] === 0){
            $fns = explode(".",$f["name"]);
            if($ext != "*"){
                if(in_array($fns[count($fns) - 1],$ext)){
                    $df = file_get_contents($f["tmp_name"]);
                    
                    // Check malicious code
                    $malcode = self::get_global("PHP_MalCode");
                    foreach($malcode as $i){
                        if(self::strcon($df,$i)){
                            array_push($danger,[$dst,$f["name"],"Contain '$i'"]);
                        }
                    }
                    
                    if(count($danger) == 0){
                        $fn = $f["name"];
                        if(file_exists($dst.$fn)){
                            if(!$skip){
                                while(file_exists($dst.$fn)){
                                    $fn = self::randstr(8,"-=!@#$%^&*()_+`~QWERTYUIOPASDFGHJKL:ZXCVBNM<>;\/?[]\\{.}|'\" ").".".$fns[count($fns) - 1];
                                }
                                move_uploaded_file($f["tmp_name"],$dst.$fn);
                            }
                        }else{
                            move_uploaded_file($f["tmp_name"],$dst.$fn);
                        }
                        return [true,$fn,$danger];
                    }else{
                        foreach($danger as $a) self::set_report($a[2]," Malicious file upload",$_SERVER["REQUEST_URI"]);
                        return [false,"",$danger];
                    }
                }else{
                    array_push($danger,[$dst,$f["name"],"Blocked extension"]);
                    return [false,"",$danger];
                }
            }else{
                $df = file_get_contents($f["tmp_name"]);
                    
                // Check malicious code
                $malcode = self::get_global("PHP_MalCode");
                foreach($malcode as $i){
                    if(self::strcon($df,$i)){
                        array_push($danger,[$dst,$f["name"],"Contain '$i'"]);
                    }
                }
                    
                if(count($danger) == 0){
                    $fn = $f["name"];
                    if(file_exists($dst.$fn)){
                        if(!$skip){
                            while(file_exists($dst.$fn)){
                                $fn = self::randstr(8,"-=!@#$%^&*()_+`~QWERTYUIOPASDFGHJKL:ZXCVBNM<>;\/?[]\\{.}|'\" ").".".$fns[count($fns) - 1];
                            }
                            move_uploaded_file($f["tmp_name"],$dst.$fn);
                        }
                    }else{
                        move_uploaded_file($f["tmp_name"],$dst.$fn);
                    }
                    return [true,$fn,$danger];
                }else{
                    foreach($danger as $a) self::set_report($a[2]," Malicious file upload",$_SERVER["REQUEST_URI"]);
                    return [false,"",$danger];
                }
            }
        }else{
            array_push($danger,[$dst,$f["name"],"Error in file"]);
            return [false,"",$danger];
        }
    }
}

?>