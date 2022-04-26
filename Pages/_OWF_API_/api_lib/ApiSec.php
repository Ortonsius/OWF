<?php

class _OWF_RID extends Control{
    public static function CheckToken($data){
        if(isset($_SESSION["_OWF_TOKEN"])){
            if($_SESSION["_OWF_TOKEN"] == false){
                return false;
            }else{
                if($data === $_SESSION["_OWF_TOKEN"]){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        return false;
    }
}


class _OWF_MultiID extends Control{
    public static function SetID($name){
        $new = [];
        foreach($name as $n){
            $_SESSION[$n] = self::randstr(8,"\\'\"`~1234567890.#<>");
            array_push($new,$_SESSION[$n]);
        }
        return $new;
    }

    public static function GetID($name){
        if(isset($_SESSION[$name]) && $_SESSION[$name] != false){
            $ret = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $ret;
        }
        return false;
    }

    public static function IsUsed($list){
        if(count($list) > 0){
            foreach($list as $i){
                if(!isset($_SESSION[$i])) return false;
                if($_SESSION[$i] == false) return false;
            }
        }
        return true;
    }
}

class _OWF_AUTH extends Control{
    private static function IP_Validation($ip1,$ip2,$priv){
        if($priv){
            // PRIVATE
            if($ip1 == $ip2){
                if($ip1 == $_SERVER["REMOTE_ADDR"]){
                    $_SESSION["_OWF_ACC_CONTROL"] = true;
                    return true;
                }else{
                    $_SESSION["_OWF_ACC_CONTROL"] = false;
                    return false;
                }
            }else{
                $_SESSION["_OWF_ACC_CONTROL"] = false;
                return false;
            }
        }else{
            // PUBLIC
            if($ip1 === $ip2 && $ip1 === $_SERVER["REMOTE_ADDR"] && $ip2 === $_SERVER["REMOTE_ADDR"]){
                $_SESSION["_OWF_ACC_CONTROL"] = true;
            }else{
                $_SESSION["_OWF_ACC_CONTROL"] = false;
            }
            return true;
        }
    }

    public static function login(){
        if(_OWF_MultiID::IsUsed(["_OWF_LOGIN_AUTHKEY","_OWF_LOGIN_PASSCODE"])){
            $keyid = _OWF_MultiID::GetID("_OWF_LOGIN_AUTHKEY");
            $pcid = _OWF_MultiID::GetID("_OWF_LOGIN_PASSCODE");
            
            $key = isset($_FILES[$keyid]) ? $_FILES[$keyid] : false;
            $passcode = isset($_POST[$pcid]) ? $_POST[$pcid] : false;
            if(($key != false && $passcode != false) === true){
                if($key["error"] === 0){
                    $datakey = file_get_contents($key["tmp_name"]);

                    //::1<#>15709845720983470894505283052342<#>mantap
                    $ork = OEN::Decrypt($datakey);

                    // IP,KEY,PWD
                    $orkprop = explode("<#>",$ork);
                    if(count($orkprop) === 3){
                        // IP,PWD,PC,KEY,PRIV
                        $auth = self::get_global("Auth");
                        foreach($auth as $a){
                            if($a[2] === $passcode){
                                if($orkprop[1] === $a[3]){
                                    if($a[1] === $orkprop[2]){
                                        if(self::IP_Validation($orkprop[0],$a[0],$a[4])){
                                            // IP_NOW<#>IP_KEY<#>PASSCODE
                                            $_SESSION["_OWF_ACC_BEARER"] = OEN::Encrypt($_SERVER["REMOTE_ADDR"]."<#>".$orkprop[0]."<#>".$passcode);
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;
        }else{
            return false;
        }
    }

    public static function logout(){
        if(isset($_SESSION["_OWF_TRAFFIC_TOKEN"])) unset($_SESSION["_OWF_TRAFFIC_TOKEN"]);
        if(isset($_SESSION["_OWF_LOGIN_AUTHKEY"])) unset($_SESSION["_OWF_LOGIN_AUTHKEY"]);
        if(isset($_SESSION["_OWF_LOGIN_PASSCODE"])) unset($_SESSION["_OWF_LOGIN_PASSCODE"]);
        if(isset($_SESSION["_OWF_ACC_CONTROL"])) unset($_SESSION["_OWF_ACC_CONTROL"]);
        if(isset($_SESSION["_OWF_ACC_BEARER"])) unset($_SESSION["_OWF_ACC_BEARER"]);
        if(isset($_SESSION["_OWF_FORM_TOKEN"])) unset($_SESSION["_OWF_FORM_TOKEN"]);
        if(isset($_SESSION["_OWF_RES_TOKEN"])) unset($_SESSION["_OWF_RES_TOKEN"]);
        if(isset($_SESSION["_OWF_WORKER_TOKEN"])) unset($_SESSION["_OWF_WORKER_TOKEN"]);
    }

    public static function credentialCheck($ret=false){
        if(isset($_SESSION["_OWF_ACC_BEARER"])){
            if($_SESSION["_OWF_ACC_BEARER"] != false){
                $bearer = OEN::Decrypt($_SESSION["_OWF_ACC_BEARER"]);
                $bearer = explode("<#>",$bearer);
                if(count($bearer) == 3){
                    if($bearer[0] != $_SERVER["REMOTE_ADDR"]){
                        $_SESSION["_OWF_ACC_BEARER"] = false;
                        $_SESSION["_OWF_ACC_CONTROL"] = false;
                        if($ret){
                            return false;
                        }else{
                            $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                            header("Location: $link");
                            exit();
                        }
                    }

                    $auth = self::get_global("Auth");
                    $is_have = false;
                    foreach($auth as $a){
                        if($a[2] == $bearer[2]){
                            $is_have = true;
                            if(self::IP_Validation($bearer[1],$a[0],$a[4])){
                                if($ret){
                                    return true;
                                }else{
                                    break;
                                }
                            }else{
                                $_SESSION["_OWF_ACC_BEARER"] = false;
                                $_SESSION["_OWF_ACC_CONTROL"] = false;
                                if($ret){
                                    return false;
                                }else{
                                    $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                                    header("Location: $link");
                                    exit();
                                }                                
                            }
                        }
                    }

                    if($is_have == false){
                        $_SESSION["_OWF_ACC_BEARER"] = false;
                        $_SESSION["_OWF_ACC_CONTROL"] = false;
                        if($ret){
                            return false;
                        }else{
                            $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                            header("Location: $link");
                            exit();
                        }
                    }
                }else{
                    $_SESSION["_OWF_ACC_BEARER"] = false;
                    $_SESSION["_OWF_ACC_CONTROL"] = false;
                    if($ret){
                        return false;
                    }else{
                        $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                        header("Location: $link");
                        exit();
                    }
                }
            }else{
                $_SESSION["_OWF_ACC_BEARER"] = false;
                $_SESSION["_OWF_ACC_CONTROL"] = false;
                if($ret){
                    return false;
                }else{
                    $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                    header("Location: $link");
                    exit();
                }
            }
        }else{
            $_SESSION["_OWF_ACC_BEARER"] = false;
            $_SESSION["_OWF_ACC_CONTROL"] = false;
            if($ret){
                return false;
            }else{
                $link = Builder::BuildLink("_OWF_PAGES_/login.php",true);
                header("Location: $link");
                exit();
            }
        }
    }
}

?>