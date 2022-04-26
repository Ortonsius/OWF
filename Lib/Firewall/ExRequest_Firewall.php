<?php

class ExReq extends Control{
    private static function reset_logger_ip($ip){
        $data = self::get_json(self::$dir."/Data/er_log.json");
        $data[$ip] = [
            "attemption" => 0,
            "last" => date("Y:m:d H:i:s")
        ];
        self::set_json(self::$dir."/Data/er_log.json",$data);
    }

    private static function set_logger($ip){
        $data = self::get_json(self::$dir."/Data/er_log.json");
        if(!isset($data[$ip]["attemption"])) $data[$ip]["attemption"] = 0;
        $data[$ip] = [
            "attemption" => intval($data[$ip]["attemption"]) + 1,
            "last" => date("Y:m:d H:i:s")
        ];
        self::set_json(self::$dir."/Data/er_log.json",$data);
    }

    private static function get_last($ip){
        $data = self::get_json(self::$dir."/Data/er_log.json");
        return $data[$ip]["last"];
    }

    private static function set_last($ip){
        $data = self::get_json(self::$dir."/Data/er_log.json");
        $data[$ip]["last"] = date("Y:m:d H:i:s");
        self::set_json(self::$dir."/Data/er_log.json",$data);
    }

    public static function Run(){
        $ip = $_SERVER["REMOTE_ADDR"];
        // if($ip != $_SERVER["SERVER_ADDR"]){
            $freq = self::get_global("exreq_sec");
            $lim = self::get_global("exreq_attempt_limit");
            $data = self::get_json(self::$dir."/Data/er_log.json");
            if(isset($data[$ip])){
                if($data[$ip]["attemption"] == $lim){
                    self::set_logger($ip);
                    self::set_report("Abnormal requests in by $ip","Abnormal requests",$_SERVER["REQUEST_URI"]);
                    self::Punishment();
                }else if($data[$ip]["attemption"] > $lim){
                    self::Punishment();
                }else{
                    $last = strtotime(self::get_last($ip));
                    $now = strtotime(date("Y:m:d H:i:s"));
                    if($now - $last <= $freq){
                        self::set_logger($ip);
                    }else if($now - $last >= self::get_global("exreq_unblock_sec")){
                        self::reset_logger_ip($ip);
                    }
                    self::set_last($ip);
                }
            }else{
                self::set_logger($ip);
            }
        // }
    }
}

ExReq::Run();
?>