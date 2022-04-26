<?php

Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

if(!isset($_SESSION["_OWF_RES_TOKEN"])){
    class _HERE_WE_GOO_ extends Control{
        public static function GO(){
            self::Punishment();
        }
    }
    _HERE_WE_GOO_::GO();
    exit();
}

$res = isset($_POST["res"]) ? $_POST["res"] : false;
$token = isset($_POST["token"]) ? $_POST["token"] : false;
$page = isset($_POST["page"]) ? $_POST["page"] : false;

if($token === $_SESSION["_OWF_RES_TOKEN"] && $_SESSION["_OWF_RES_TOKEN"] != false && $_SESSION["_OWF_RES_TOKEN"] != ""){
    if($res != false){
        $indPage = intval($page);
        if($indPage <= 0){
            $indPage = 1;
        }

        $_SESSION["_OWF_RES_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
        if($res == "REPORT"){
            class _NOT_ extends Control{
                public static function getJson($loc){
                    return self::get_json($loc);
                }
            }
            
            $data = _NOT_::getJson(Control::$dir."/data/alert.json");
            $data = isset($data) ? $data : [];

            $counter = 0;
            $endPagination = $indPage * 10;
            $startPagination = $endPagination - 10;
            $dlen = isset($data) ? count($data) : 0;

            echo $_SESSION["_OWF_RES_TOKEN"];
            if($dlen <= $startPagination){
                while($startPagination >= $dlen) $startPagination -=10;
                if($startPagination < 0) $startPagination = 0;
                $endPagination = $startPagination + 10;
                echo "false";
            }

            echo "<section class=\"data-list\">";
            foreach($data as $key => $val){
                if($counter < $endPagination){
                    if($counter >= $startPagination){
                        echo "
                            <div class=\"dlb\">
                                <input type=\"hidden\" id=\"RP-ID\" value=\"$key\"></input>
                                <div class=\"datab-read font-it\">
                                    <p class=\"report-title\">".$val["type"]."</p>
                                    <div class=\"report-info\">
                                        <div class=\"lr-info\">
                                            <div class=\"rptinfo-key\"><div>URL  </div>: ".htmlspecialchars($val["url"])."</div>
                                            <div class=\"rptinfo-key\"><div>IP   </div>: ".htmlspecialchars($val["ip"])."</div>
                                            <div class=\"rptinfo-key\"><div>DATE </div>: ".htmlspecialchars($val["date"])."</div>
                                        </div>
                                        <div class=\"mid-line\"></div>
                                        <div class=\"rr-info\">
                                            ".htmlspecialchars($val["desc"])."
                                        </div>
                                    </div>
                                </div>
                                <div class=\"datab-action\ font-it\">
                                    <div class=\"btn-res-act btn-res-edit owf-reg-res-edit\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'save','REPORT','$key')
                                    \">SAVE</div>
                                    <div class=\"btn-res-act btn-res-del owf-reg-res-del\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','REPORT','$key');
                                        rester('REPORT','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                    \">DELETE</div>
                                </div>
                            </div>
                        ";
                    }
                }else{
                    break;
                }
                $counter++;
            }
            echo "</section>";

        }else if($res == "ACCOUNT"){
            if($_SESSION["_OWF_ACC_CONTROL"]){
                class _NOT_ extends Control{
                    public static function getJson($loc){
                        return self::get_json($loc);
                    }

                    public static function getGlob($key){
                        return self::get_global($key);
                    }
                }
                $data = _NOT_::getGlob("Auth");
                $data = isset($data) ? $data : [];

                $counter = 0;
                $endPagination = $indPage * 10;
                $startPagination = $endPagination - 10;
                $dlen = count($data);

                echo $_SESSION["_OWF_RES_TOKEN"];
                if($dlen <= $startPagination){
                    while($startPagination >= $dlen) $startPagination -=10;
                    if($startPagination < 0) $startPagination = 0;
                    $endPagination = $startPagination + 10;
                    echo "false";
                }

                echo "<section class=\"data-list\">";
                foreach($data as $i){
                    if($counter < $endPagination){
                        if($counter >= $startPagination){
                            echo "<div class=\"dl\">";
                            echo "  <div class=\"data-read font-it\">";
                            echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($i[0])."</p>";
                            echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($i[1])."</p>";
                            echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($i[2])."</p>";
                            echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($i[3])."</p>";
                            echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($i[5])."</p>";
                            echo "      <p class=\"owf-reg-res-val\">".($i[4] ? "Private" : "Public")."</p>";
                            echo "  </div>";
                            echo "  <div class=\"data-action\">";
                            echo "      <div class=\"btn-res-act btn-res-edit owf-reg-res-edit\" onclick=\"linker('ACCOUNT','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'edit','".$i[2]."')\">EDIT</div>";
                            echo "      <div class=\"btn-res-act btn-res-del owf-reg-res-del\" onclick=\"
                                            workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','ACCOUNT','".$i[2]."');
                                            rester('ACCOUNT','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                            linker('ACCOUNT','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')\">DELETE</div>";
                            echo "  </div>";
                            echo "</div>";
                        }
                    }else{
                        break;
                    }
                    $counter++;
                }
                echo "</section>";
            }else{
                echo "<p class=\"err-msg font-it\">You're not have access to this page</p>";
            }
        }else if($res == "URL"){
            class _NOT_ extends Control{
                public static function getJson($loc){
                    return self::get_json($loc);
                }
            }
            $data = _NOT_::getJson(Control::$dir."/Data/pages.json");
            $data = isset($data) ? $data : [];

            $counter = 0;
            $endPagination = $indPage * 10;
            $startPagination = $endPagination - 10;
            $dlen = count($data) - 14;

            echo $_SESSION["_OWF_RES_TOKEN"];
            if($dlen <= $startPagination){
                while($startPagination >= $dlen) $startPagination -=10;
                if($startPagination < 0) $startPagination = 0;
                $endPagination = $startPagination + 10;
                echo "false";
            }
           
            echo "<section class=\"data-list\">";
            foreach($data as $key => $val){
                if(substr($key,0,3) != "OWF"){
                    if($counter < $endPagination){
                        if($counter >= $startPagination){
                            echo "
                                <div class=\"dlb\">
                                    <input type=\"hidden\" id=\"PG-ID\" value=\"$key\"></input>
                                    <div class=\"datab-read font-it\">
                                        <p class=\"report-title\">".$val["loc"]."</p>
                                        <div class=\"report-info\">
                                            <div class=\"lu-info\">
                                                <div class=\"rptinfo-key\"><div>URL  </div>: ".htmlspecialchars($val["url"])."</div>
                                                <div class=\"rptinfo-key\"><div>METHOD   </div>: ".htmlspecialchars(implode(", ",$val["method"]))."</div>
                                                <div class=\"rptinfo-key\"><div>TYPE </div>: ".htmlspecialchars($val["type"])."</div>
                                                <div class=\"rptinfo-key\"><div>IP  </div>: ".htmlspecialchars(implode(",",$val["ip"]))."</div>
                                                <div class=\"rptinfo-key\"><div>SEC   </div>: ".htmlspecialchars($val["sec"])."</div>
                                                <div class=\"rptinfo-key\"><div>FIREWALL </div>: ".htmlspecialchars(implode(",",$val["firewall"]))."</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"datab-action font-it\">
                                        <div class=\"btn-res-act btn-res-del owf-reg-res-del\" style=\"height: 20vh;\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','URL','$key');
                                        rester('URL','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                        linker('URL','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')
                                        \">DELETE</div>
                                    </div>
                                </div>
                            ";
                        }
                    }else{
                        break;
                    }
                    $counter++;
                }
            }
            echo "</section>";
            
        }else if($res == "FIREWALL"){
            class _NOT_ extends Control{
                public static function getJson($loc){
                    return self::get_json($loc);
                }
            }

            $data = _NOT_::getJson(Control::$dir."/Data/firewall_ls.json");
            $data = isset($data) ? $data : [];
            
            $counter = 0;
            $endPagination = $indPage * 10;
            $startPagination = $endPagination - 10;
            $dlen = count($data);

            echo $_SESSION["_OWF_RES_TOKEN"];
            if($dlen <= $startPagination){
                while($startPagination >= $dlen) $startPagination -=10;
                if($startPagination < 0) $startPagination = 0;
                $endPagination = $startPagination + 10;
                echo "false";
            }

            echo "<section class=\"data-list\">";
            foreach($data as $key => $val){
                if($counter < $endPagination){
                    if($counter >= $startPagination){
                        echo "<div class=\"dl\">";
                        echo "  <div class=\"data-read font-it\">";
                        echo "      <p class=\"owf-reg-res-key\">".htmlspecialchars($key)."</p>";
                        echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars($val)."</p>";
                        echo "  </div>";
                        echo "  <div class=\"data-action\">";
                        echo "      <div class=\"btn-res-act btn-res-edit owf-reg-res-edit\" onclick=\"linker('FIREWALL','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'edit','$key')\">EDIT</div>";
                        echo "      <div class=\"btn-res-act btn-res-del owf-reg-res-del\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','FIREWALL','".$key."');
                                        rester('FIREWALL','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                        linker('FIREWALL','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')\">DELETE</div>";
                        echo "  </div>";
                        echo "</div>";
                    }
                }else{
                    break;
                }
                $counter++;
            }
            echo "</section>";
            
        }else if($res == "SCANNER"){
            class _NOT_ extends Control{
                public static function getJson($loc){
                    return self::get_json($loc);
                }
            }

            $data = _NOT_::getJson(Control::$dir."/Data/scanner_ls.json");
            $data = isset($data) ? $data : [];
            
            $counter = 0;
            $endPagination = $indPage * 10;
            $startPagination = $endPagination - 10;
            $dlen = count($data);

            echo $_SESSION["_OWF_RES_TOKEN"];
            if($dlen <= $startPagination){
                while($startPagination >= $dlen) $startPagination -=10;
                if($startPagination < 0) $startPagination = 0;
                $endPagination = $startPagination + 10;
                echo "false";
            }

            echo "<section class=\"data-list\">";
            foreach($data as $key => $val){
                if($counter < $endPagination){
                    if($counter >= $startPagination){
                        echo "<div class=\"dl\">";
                        echo "  <div class=\"data-read font-it\">";
                        echo "      <p class=\"owf-reg-res-key\">".htmlspecialchars($val)."</p>";
                        echo "  </div>";
                        echo "  <div class=\"data-action\">";
                        echo "      <div class=\"btn-res-act btn-res-edit owf-reg-res-edit\" id=\"owf-sc-run\" onclick=\"
                            var rq = new ReqJS('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."','POST');
                            rq.setData([
                                ['id','$key'],
                                ['com','run'],
                                ['page','SCANNER'],
                                ['token',document.querySelector('#OWF_TOKEN_WORKER').value]
                            ])
                            document.querySelector('#owf-sc-run').innerHTML = 'RUNNING';
                            rq.send(r => {
                                if(r.length > 8){
                                    document.querySelector('#OWF_TOKEN_WORKER').value = r.substring(0,8);
                                    document.querySelector('#owf-sc-run').innerHTML = 'RUN';
                                    alert(r.substring(8,r.length));
                                }
                            })
                        \">RUN</div>";
                        echo "      <div class=\"btn-res-act btn-res-del owf-reg-res-del\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','SCANNER','".htmlspecialchars($key)."');
                                        rester('SCANNER','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                        linker('SCANNER','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'imp')\">DELETE</div>";
                        echo "  </div>";
                        echo "</div>";
                    }
                }else{
                    break;
                }
                $counter++;
            }
            echo "</section>";
            
        }else if($res == "REGISTRY"){
            class _NOT_ extends Control{
                public static function getJson($loc){
                    return self::get_json($loc);
                }
            }

            $data = _NOT_::getJson(Control::$dir."/Data/global.json");
            $data = isset($data) ? $data : [];
            
            $counter = 0;
            $endPagination = $indPage * 10;
            $startPagination = $endPagination - 10;
            $dlen = count($data);

            echo $_SESSION["_OWF_RES_TOKEN"];
            if($dlen <= $startPagination){
                while($startPagination >= $dlen) $startPagination -=10;
                if($startPagination < 0) $startPagination = 0;
                $endPagination = $startPagination + 10;
                echo "false";
            }

            echo "<section class=\"data-list\">";
            foreach($data as $key => $val){
                if($counter < $endPagination){
                    if($counter >= $startPagination){
                        echo "<div class=\"dl\">";
                        echo "  <div class=\"data-read font-it\">";
                        echo "      <p class=\"owf-reg-res-key\">".htmlspecialchars($key)."</p>";
                        echo "      <p class=\"owf-reg-res-val\">".htmlspecialchars(((gettype($val) != "array") ? strval($val) : "[object]"))."</p>";
                        echo "  </div>";
                        echo "  <div class=\"data-action\">";
                        echo "      <div class=\"btn-res-act btn-res-edit owf-reg-res-edit\" onclick=\"linker('REGISTRY','".Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true)."',document.querySelector('#OWF_TOKEN_FORM'),cform,'edit','$key')\">EDIT</div>";
                        echo "      <div class=\"btn-res-act btn-res-del owf-reg-res-del\" onclick=\"
                                        workster('".Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true)."',document.querySelector('#OWF_TOKEN_WORKER'),'del','REGISTRY','".htmlspecialchars($key)."');
                                        rester('REGISTRY','".Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true)."',$page,document.querySelector('#OWF_TOKEN_RES'),resPage,indexPage);
                                        document.querySelector('#owf-key').value='';
                                        document.querySelector('#owf-value').value='';
                                        document.querySelector('#OWF_FORM_SUBMIT').innerHTML = 'ADD';\">DELETE</div>";
                        echo "  </div>";
                        echo "</div>";
                    }
                }else{
                    break;
                }
                $counter++;
            }
            echo "</section>";
        }
    }else{
        $_SESSION["_OWF_RES_TOKEN"] = Control::randstr(8,"\\\"'`~<>");
        echo "nice try!!";
    }
}
?>