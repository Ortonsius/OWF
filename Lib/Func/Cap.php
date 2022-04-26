<?php

class CaptureClient extends Control{
    public static function Capture(){
        $ip = $_SERVER["REMOTE_ADDR"];
        $data = json_decode(file_get_contents("https://extreme-ip-lookup.com/json/".$ip),true);

        if($data["status"] == "success"){
            $country_block = self::get_global("country_block");
            $region_block = self::get_global("region_block");
            $city_block = self::get_global("city_block");

            if(in_array($data["country"],$country_block)){
                self::Punishment();
            }
            
            if(in_array($data["city"],$city_block)){
                self::Punishment();
            }
            
            if(in_array($data["region"],$region_block)){
                self::Punishment();
            }
        }else{
            self::Punishment();
        }
    }
}

?>