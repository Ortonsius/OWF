<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

if(!isset($_SESSION["_OWF_WORKER_TOKEN"])){
    class _HERE_WE_GOO_ extends Control{
        public static function GO(){
            self::Punishment();
        }
    }
    _HERE_WE_GOO_::GO();
    exit();
}

$com = isset($_POST["com"]) ? $_POST["com"] : false;
$page = isset($_POST["page"]) ? $_POST["page"] : false;
$token = isset($_POST["token"]) ? $_POST["token"] : false;
$id = isset($_POST["id"]) ? $_POST["id"] : false;

if($token === $_SESSION["_OWF_WORKER_TOKEN"] && $_SESSION["_OWF_WORKER_TOKEN"] != false && $_SESSION["_OWF_WORKER_TOKEN"] != ""){
    if($page != false){
        if($com != false && in_array($com,["edit","del","add","save","run"])){
            if($page == "REPORT"){
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }
                    public static function setJson($fl,$d){
                        self::set_json($fl,$d);
                    }
                }

                $globloc = Control::$dir."/data/alert.json";
                $data = _NOT_::getJson($globloc);
                if($com == "del"){
                    if($id != false){
                        if(isset($data[$id])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            unset($data[$id]);
                            _NOT_::setJson($globloc,$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }else{
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }else if($com == "save"){
                    if(isset($data[$id])){
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        $lock_data = _NOT_::getJson(Control::$dir."/data/lock_alert.json");
                        $getData = $data[$id];
                        
                        $raw_id = str_replace("ALERT-","",$id);
                        if($lock_data == ""){
                            $lock_data["LOCKED_ALERT-".$raw_id] = $getData;
                        }else{
                            if(!isset($lock_data["LOCKED_ALERT-".$raw_id])){
                                $lock_data["LOCKED_ALERT-".$raw_id] = $getData;
                            }
                        }

                        _NOT_::setJson(Control::$dir."/data/lock_alert.json",$lock_data);
                        echo $_SESSION["_OWF_WORKER_TOKEN"];
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }

            }else if($page == "ACCOUNT"){
                if($_SESSION["_OWF_ACC_CONTROL"]){
                    class _NOT_ extends Control{
                        public static function getGlob($key){
                            return self::get_global($key);
                        }
                        
                        public static function setGlob($key,$value){
                            self::set_global($key,$value);
                        }
                    }

                    $data = _NOT_::getGlob("Auth");
                    
                    if($com == "del"){
                        if($id != false){
                            $x = 0;
                            foreach($data as $i){
                                if($i[2] == $id){
                                    unset($data[$x]);
                                    echo $_SESSION["_OWF_WORKER_TOKEN"];
                                    break;
                                }
                                $x++;
                            }

                            _NOT_::setGLob("Auth",$data);
                        }
                    }else if($com == "edit"){
                        $pc = isset($_POST["pc"]) ? $_POST["pc"] : false;
                        $value = isset($_POST["value"]) ? $_POST["value"] : false;
                        $ty = isset($_POST["ty"]) ? $_POST["ty"] : false;
                        if($id != false){
                            if($value != false && $ty != false && $pc != false){
                                $ip = $_SERVER["REMOTE_ADDR"];
                                $typ = $ty == "true" ? true : false;
                                $key = Control::randstr(32,"qwertyuiopasdfghjklzxcvbnmQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");

                                $klist = [];
                                foreach($data as $i){
                                    array_push($klist,$i[3]);
                                }

                                while(in_array($key,$klist)) $key = Control::randstr(16,"qwertyuiopasdfghjklzxcvbnmQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                        
                                $x = 0;
                                foreach($data as $i){
                                    if($i[2] == $pc){
                                        break;
                                    }else{
                                        $x++;
                                    }
                                }

                                $data[$x][0] = $ip;
                                $data[$x][1] = $value;
                                $data[$x][2] = $pc;
                                $data[$x][3] = $key;
                                $data[$x][4] = $typ;
                                $data[$x][5] = $id;

                                _NOT_::setGlob("Auth",$data);
                                echo $_SESSION["_OWF_WORKER_TOKEN"];
                            }
                        }
                    }else if($com == "add"){
                        $value = isset($_POST["value"]) ? $_POST["value"] : false;
                        $ty = isset($_POST["ty"]) ? $_POST["ty"] : false;
                        if($id != false){
                            if($value != false && $ty != false){
                                $ip = $_SERVER["REMOTE_ADDR"];
                                $typ = $ty == "true" ? true : false;
                                $key = Control::randstr(32,"qwertyuiopasdfghjklzxcvbnmQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                $pc =  Control::randstr(16,"QAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                $klist = [];
                                $plist = [];
                                foreach($data as $i){
                                    array_push($klist,$i[3]);
                                    array_push($plist,$i[2]);
                                }

                                while(in_array($key,$klist)) $key = Control::randstr(16,"qwertyuiopasdfghjklzxcvbnmQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                while(in_array($pc,$plist)) $pc =  Control::randstr(8,"QAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                
                                array_push($data,[$ip,$value,$pc,$key,$typ,$id]);
                                _NOT_::setGlob("Auth",$data);
                                echo $_SESSION["_OWF_WORKER_TOKEN"];
                                echo OEN::Encrypt("$ip<#>$key<#>$value");
                            }
                        }
                    }
                }
            }else if($page == "URL"){
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }
                    public static function setJson($fl,$d){
                        self::set_json($fl,$d);
                    }
                }
                
                $globloc = Control::$dir."/data/pages.json";
                $data = _NOT_::getJson($globloc);

                $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                
                if($com == "del"){
                    if($id != false){
                        if(isset($data[$id])){
                            $rloc = $data[$id]["loc"];
                            if(file_exists(Control::$dir."/pages/".$rloc)){
                                unlink(Control::$dir."/pages/".$rloc);
                            }
                            unset($data[$id]);
                            _NOT_::setJson($globloc,$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }
                    }
                }else if($com == "add"){
                    if($id != false){
                        $url = json_decode($id);
                        $f = isset($_FILES["f"]) ? $_FILES["f"] : false;
                        $ctype = isset($_POST["ctype"]) ? $_POST["ctype"] : false;
                        $ptype = isset($_POST["ptype"]) ? $_POST["ptype"] : false;
                        $method = isset($_POST["method"]) ? json_decode($_POST["method"]) : [];
                        $ip = isset($_POST["ip"]) ? json_decode($_POST["ip"]) : [];
                        $fw = isset($_POST["fw"]) ? json_decode($_POST["fw"]) : [];
                        
                        if(!in_array(false,[$f,$ctype,$ptype])){
                            foreach($url as $i){
                                $dtp = [];
                                $pageid = "PAGES-".Control::randstr(8,"!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                $usedpid = [];
                                foreach($data as $k => $v){
                                    array_push($usedpid,$k);
                                }
                                while(in_array($pageid,$usedpid)) $pageid = "PAGES-".Control::randstr(8,"!@#$%^&*()`~-=_+[]\\{}|;'\":,./<>?");
                                $res = Control::FileMove($f,Control::$dir."/pages/","*",true);
                                if($res[0]){
                                    $data[$pageid] = [
                                        "url" => $i,
                                        "loc" => $res[1],
                                        "method" => $method,
                                        "firewall" => $fw,
                                        "type" => $ctype,
                                        "sec" => $ptype,
                                        "ip" => $ip
                                    ];

                                    _NOT_::setJson($globloc,$data);
                                    echo $_SESSION["_OWF_WORKER_TOKEN"];
                                }
                            }
                        }
                    }
                }
            }else if($page == "FIREWALL"){
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }
                    public static function setJson($fl,$d){
                        self::set_json($fl,$d);
                    }

                    public static function setrpt($desc,$type){
                        self::set_report($desc,$type,$_SERVER["REQUEST_URI"]);
                    }
                }
                
                $globloc = Control::$dir."/data/firewall_ls.json";
                $data = _NOT_::getJson($globloc);
                
                if($com == "del"){
                    if($id != false){
                        if(isset($data[$id])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            if(file_exists(Control::$dir."/lib/firewall/".$data[$id])){
                                unlink(Control::$dir."/lib/firewall/".$data[$id]);
                                unset($data[$id]);
                            }else{
                                // file cannot deleted
                            }
                            _NOT_::setJson($globloc,$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }else{
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }else if($com == "add"){
                    if($id != false){
                        if(isset($_FILES["owf-fw-file"])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            if(!isset($data[$id])){
                                $res = Control::FileMove($_FILES["owf-fw-file"],Control::$dir."/lib/firewall/",["php"]);
                                if(!$res[0]){
                                    // res = false
                                    foreach($res[2] as $i){
                                        // all danger included
                                        echo $_SESSION["_OWF_WORKER_TOKEN"];
                                        echo "WARNING: This file maybe not secured";
                                        _NOT_::setrpt($_FILES["owf-fw-file"]["name"]." maybe not secured: ".$i,"RCE,LFI");
                                    }
                                }else{
                                    // res = true
                                    $data = _NOT_::getJson(Control::$dir."/data/firewall_ls.json");
                                    $data[$id] = $res[1];
                                    _NOT_::setJson(Control::$dir."/data/firewall_ls.json",$data);
                                    echo $_SESSION["_OWF_WORKER_TOKEN"];
                                }
                            }
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }else if($com == "edit"){
                    if($id != false){
                        if(isset($_FILES["owf-fw-file"])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            if(isset($data[$id])){
                                $f = $_FILES["owf-fw-file"];
                                $dst = Control::$dir."/lib/firewall/";
                                echo $_SESSION["_OWF_WORKER_TOKEN"];

                                
                                $danger = [];
                                $ext = ["php"];
                                // DEST NAME, ORI NAME, msg
                                if($f["error"] === 0){
                                    $fns = explode(".",$f["name"]);
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
                                            if($data[$id] != $fn) unlink($dst.$data[$id]);
                                            $data[$id] = $fn;
                                            move_uploaded_file($f["tmp_name"],$dst.$fn);

                                            _NOT_::setJson($globloc,$data);
                                        }else{
                                            foreach($danger as $a) self::set_report($a[2]," Malicious file upload",$_SERVER["REQUEST_URI"]);
                                            echo "This file contain malicious code";
                                        }
                                    }else{
                                        array_push($danger,[$dst,$f["name"],"Blocked extension"]);
                                        foreach($danger as $a) self::set_report($a[2]," Malicious file upload",$_SERVER["REQUEST_URI"]);
                                    }
                                }else{
                                    array_push($danger,[$dst,$f["name"],"Error in file"]);
                                    foreach($danger as $a) self::set_report($a[2]," Malicious file upload",$_SERVER["REQUEST_URI"]);
                                }
                            }
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }
            }else if($page == "SCANNER"){
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }
                    public static function setJson($fl,$d){
                        self::set_json($fl,$d);
                    }

                    public static function setrpt($desc,$type){
                        self::set_report($desc,$type,$_SERVER["REQUEST_URI"]);
                    }
                }
                
                $globloc = Control::$dir."/data/scanner_ls.json";
                $data = _NOT_::getJson($globloc);
                
                if($com == "del"){
                    if($id != false){
                        if(isset($data[$id])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            if(file_exists(Control::$dir."/lib/scanner/".$data[$id])){
                                unlink(Control::$dir."/lib/scanner/".$data[$id]);
                                unset($data[$id]);
                            }else{
                                // file cannot deleted
                            }
                            _NOT_::setJson($globloc,$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }else{
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }else if($com == "add"){
                    if(isset($_FILES["owf-sc-file"])){
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        $res = Control::FileMove($_FILES["owf-sc-file"],Control::$dir."/lib/scanner/",["php"]);
                        if(!$res[0]){
                            // res = false
                            foreach($res[2] as $i){
                                // all danger included
                                echo $_SESSION["_OWF_WORKER_TOKEN"];
                                echo "WARNING: This file maybe not secured";
                                _NOT_::setrpt($_FILES["owf-sc-file"]["name"]." maybe not secured: ".$i,"RCE,LFI");
                            }
                        }else{
                            // res = true
                            $sid = "SCANNER-".Control::randstr(8,"-=!@#$%^&*()_+`~:<>;\/?[]\\{}|'\" ,.");
                            $data = _NOT_::getJson(Control::$dir."/data/scanner_ls.json");
                            $data[$sid] = $res[1];
                            _NOT_::setJson(Control::$dir."/data/scanner_ls.json",$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }
                    }
                }else if($com == "run"){
                    $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    $globloc = Control::$dir."/data/scanner_ls.json";
                    $data = _NOT_::getJson($globloc);

                    foreach($data as $k => $v){
                        if($id == $k){
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                            Importer::import(Control::$dir."/lib/scanner/".$v);
                            break;
                        }
                    }
                }
                
            }else if($page == "REGISTRY"){
                // ============================== REGISTRY WORK AREA ==============================
                
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }
                    public static function setJson($fl,$d){
                        self::set_json($fl,$d);
                    }
                }
                
                $globloc = Control::$dir."/data/global.json";
                $data = _NOT_::getJson($globloc);
                if($com == "add"){
                    $value = isset($_POST["value"]) ? $_POST["value"] : false;
                    if($value != false){
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        $da = _NOT_::getJson($globloc);
                        $da[$id] = $value;
                        _NOT_::setJson($globloc,$da);
                        echo $_SESSION["_OWF_WORKER_TOKEN"];
                    }
                }else if($com == "edit"){
                    if($id != false){
                        if(isset($data[$id])){
                            $value = isset($_POST["value"]) ? $_POST["value"] : false;
                            if($value != false){
                                $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                                $data[$id] = $_POST["value"];
                                _NOT_::setJson($globloc,$data);
                                echo $_SESSION["_OWF_WORKER_TOKEN"];
                            }
                        }else{
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }else if($com == "del"){
                    if($id != false){
                        if(isset($data[$id])){
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                            unset($data[$id]);
                            _NOT_::setJson($globloc,$data);
                            echo $_SESSION["_OWF_WORKER_TOKEN"];
                        }else{
                            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                        }
                    }else{
                        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
                    }
                }

                // ================================================================================
            } 
        }else{
            $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
        }
    }else{
        $_SESSION["_OWF_WORKER_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
    }
}
?>