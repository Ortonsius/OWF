<?php

class SessionFirewall extends Control{
    private static $okey;
    private static function check_cookie(){
        // p t
        // a a = skip
        // a g = 
        // g a
        // g g
        
        if(!isset($_COOKIE["PHPSESSID"]) && !isset($_COOKIE["OKEY"])){
            session_regenerate_id();
            $tok = OEN::Encrypt(session_id()."<#>".$_SERVER["REMOTE_ADDR"]);
            setcookie("OKEY",$tok);
            self::$okey = $tok;
        }else if(isset($_COOKIE["PHPSESSID"]) && isset($_COOKIE["OKEY"])){
            NULL;            
        }else{
            self::set_report($_SERVER["REMOTE_ADDR"]." try to manipulate token","Unusual session",$_SERVER["REQUEST_URI"]);
            if(isset($_COOKIE["OKEY"])){
                unset($_COOKIE["PHPSESSID"]);
                unset($_COOKIE["OKEY"]);
                setcookie("OKEY",null);
                setcookie("PHPSESSID",null,1,'/');

            }

            if(isset($_COOKIE["PHPSESSID"])){
                setcookie("PHPSESSID",null,1,'/');
                unset($_COOKIE["PHPSESSID"]);
            }

            self::Punishment();
        }
    }

    public static function Run(){
        self::check_cookie();
        $ip = $_SERVER["REMOTE_ADDR"];
        $ori_sid = isset($_COOKIE["PHPSESSID"]) ? $_COOKIE["PHPSESSID"] : session_id();
        $okey = isset($_COOKIE["OKEY"]) ? OEN::Decrypt($_COOKIE["OKEY"]) : OEN::Decrypt(self::$okey);

        $arr = explode("<#>",$okey);
        if($arr[0] != $ori_sid){
            self::set_report("$ip Try to steal ". $arr[1]." cookies","Cookie stealing",$_SERVER["REQUEST_URI"]);
            self::Punishment();
        }

        if($ip != $arr[1]){
            self::set_report("$ip Try to steal ". $arr[1]." cookies","Cookie stealing",$_SERVER["REQUEST_URI"]);
            self::Punishment();
        }
    }
}

SessionFirewall::Run();

?>