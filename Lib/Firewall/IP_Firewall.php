<?php

class IPFirewall extends Control{
    public static function Run(){
        $data = self::get_global("block_ip");
        if(in_array($_SERVER["REMOTE_ADDR"],$data)){
            self::set_report($_SERVER["REMOTE_ADDR"]." trying to get in to website","Banned IP",$_SERVER["REQUEST_URI"]);
            self::Punishment();
        }
    }
}

IPFirewall::Run();

?>