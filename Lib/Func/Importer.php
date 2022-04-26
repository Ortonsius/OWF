<?php

class Importer extends Control{
    private static $stat = false;

    public static function initSetup(){
        set_error_handler("Importer::error_handling");
        set_exception_handler("Importer::exception_handling");
    }

    public static function error_handling($errno,$errmsg){
        self::$stat = true;
        self::log_error("[".strval($errno)."]: ".$errmsg,"ERROR");
    }
    
    public static function exception_handling($exc){
        self::$stat = true;
        self::log_error("[".strval($exc->getCode())."]: ".$exc->getMessage(),"EXCEPTION");
    }
    
    public static function import($file){
        self::$stat = false;
        ob_start();
        self::initSetup();
        include_once $file;
        if(self::$stat){
            ob_end_clean();
            include_once self::$dir . "/Pages/404.php";
            exit();
        }
    }
}

Importer::initSetup();

?>