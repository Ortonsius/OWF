<?php

class PortScan{
    private static function dumper($a,$i){
        $l = null;
    }

    public static function Run($ps,$pe){
        $port_open = [];
        $nn = false;
        if($ps <= $pe){
            if($ps > 0){
                if($pe < 65535){
                    set_error_handler("self::dumper");
                    for($i = $ps; $i <= $pe; $i++){
                        if($f = fsockopen($_SERVER["SERVER_NAME"],$i)){
                            $nn = true;

                            array_push($port_open,"[>>] Port Open: ".strval($i));
                            fclose($f);
                        }
                    }
                }else{
                    echo "[>>] Invalid parameter !!";
                    return;
                }
            }else{
                echo "[>>] Invalid parameter !!";
                return;
            }
        }else{
            echo "[>>] Invalid parameter !!";
            return;
        }
        
        if($nn){
            echo join("\n",$port_open);
        }else{
            echo "[>>] All scanned port: close";
        }
    }
}

PortScan::Run(78,80);
?>