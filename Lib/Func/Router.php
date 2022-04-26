<?php

class Router extends Control{
    private static function ProdOriUrl($url){
        $e = explode("/",$url);
        $el = $e[count($e) - 1];
        $pos = strpos($el,"?");
        if($pos == NULL){
            return $url;
        }
        $new_last = substr($el,0,$pos);

        $e[count($e) - 1] = $new_last;
        $e = implode("/",$e);
        return $e;
    }

    public static function Route($url,$method){
        $ip = $_SERVER["REMOTE_ADDR"];
        $pages = self::get_page();
        $url = strtolower(self::ProdOriUrl($url));
        $isp = false;

        foreach($pages as $_ => $v){
            if(strtolower($v["url"]) == $url){
                if($v["sec"] == "private"){
                    if(in_array($ip,$v["ip"])){
                        if(in_array($method,$v["method"])){
                            $fw = self::get_fwl();
                            foreach($fw as $i){
                                foreach($v["firewall"] as $j){
                                    if($i[0] == $j){
                                        Importer::import(self::$dir."/Lib/Firewall/".$i[1]);
                                    }
                                }
                            }
    
                            // CaptureClient::Capture();
                            header("Content-type: ".$v["type"]);
                            Importer::import(self::$dir."/Pages/".$v["loc"]);
                            $isp = true;
                            exit();
                        }
                    }else{
                        self::set_report("$ip try to visit private page","Restricted page",$_SERVER["REQUEST_URI"]);
                        self::Punishment();
                    }
                }else{
                    if(!in_array($ip,$v["ip"])){
                        if(in_array($method,$v["method"])){
                            $fw = self::get_fwl();
                            foreach($fw as $i){
                                foreach($v["firewall"] as $j){
                                    if($i[0] == $j){
                                        Importer::import(self::$dir."/Lib/Firewall/".$i[1]);
                                    }
                                }
                            }

                            // CaptureClient::Capture();
                            header("Content-type: ".$v["type"]);
                            Importer::import(self::$dir."/Pages/".$v["loc"]);
                            $isp = true;
                            exit();
                        }
                    }else{
                        self::set_report("$ip try to visit that got banned","Banned from page",$_SERVER["REQUEST_URI"]);
                        self::Punishment();
                    }
                }
            }
        }
        
        if($isp == false){
            self::Punishment();
        }
    }
}

?>