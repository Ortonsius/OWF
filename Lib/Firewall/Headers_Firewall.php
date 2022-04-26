<?php

class HeadFW extends Control{
    private static function check_validity($h){
        if(!isset($h["User-Agent"])){
            self::Punishment();
        }
    }

    private static function user_agent_check($str){
        $blocked = self::get_global("block_user_agent");
        foreach($blocked as $v){
            $tmp = strpos($str,strtolower($v));
            if(strval($tmp) != ""){
                self::set_report("Malicious user agent name: $str","Bot",$_SERVER["REQUEST_URI"]);
                self::Punishment();
            }
        }
    }

    private static function HTTP_data_check(){
        $ip = $_SERVER["REMOTE_ADDR"];
        $banned_http_word = self::get_global("http_data_banned");
        $method = $_SERVER["REQUEST_METHOD"];
        if($method == "GET"){
            foreach($_GET as $k => $v){
                foreach($banned_http_word as $i){
                    if($i == $k || $i == $v){
                        self::set_report("Unwanted HTTP data word from $ip: $i","HTTP Banned word",$_SERVER["REQUEST_URI"]);
                        self::Punishment();
                    }
                }
            }
        }else if($method == "POST"){
            foreach($_POST as $k => $v){
                foreach($banned_http_word as $i){
                    if($i == $k || $i == $v){
                        self::set_report("Unwanted HTTP data word from $ip: $i","HTTP Banned word",$_SERVER["REQUEST_URI"]);
                        self::Punishment();
                    }
                }
            }
        }
    }

    public static function Run(){
        $header = apache_request_headers();
        if(isset($header["User-Agent"])){
            self::user_agent_check(strtolower($header["User-Agent"]));
        }else{
            self::Punishment();
        }
        self::HTTP_data_check();
    }
}

HeadFW::Run();

?>