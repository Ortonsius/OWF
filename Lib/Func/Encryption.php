<?php

class OEN extends Control{
    public static function LenBlocker($text){
        $key = self::get_global("key");
        $result = "";
        $textlen = strlen($text);
        $keylen = strlen($key);
        $counter = $textlen;
        $n = 1;

        while($n * 32 < $textlen) $n++;

        for($i = 0; $i < $textlen; $i++){
            $block = "";
            $rand = mt_rand(1,3);
            $block .= strval($rand);
            for($j = 1; $j < 4; $j++){
                if($j == $rand){
                    $block .= $text[$i];
                }else{
                    $block .= $key[mt_rand(0,$keylen - 1)];
                }
            }
            $result .= $block;
            unset($block);
        }
        
        while($counter < $n * 8){
            $block = "";
            $block .= "-";
            $block .= strval($key[mt_rand(0,$keylen - 1)]);
            $block .= strval($key[mt_rand(0,$keylen - 1)]);
            $block .= strval($key[mt_rand(0,$keylen - 1)]);
            $result .= $block;
            unset($block);
            $counter++;
        }
        return $result;
    }

    public static function LenReader($text){
        $tlen = strlen($text);
        $res = "";
        for($i = 0; $i < $tlen; $i += 4){
            if($text[$i] != '-'){
                $indic = $text[$i];
                $res .= $text[intval($indic) + $i];
            }
        }
        return $res;
    }

    public static function Encrypt($text){
        $lb = self::LenBlocker($text);
        return openssl_encrypt($lb,"AES-128-CTR",self::get_global("key"),0,self::get_global("iv"));
    }

    public static function Decrypt($text){
        $lb = openssl_decrypt($text,"AES-128-CTR",self::get_global("key"),0,self::get_global("iv"));
        return self::LenReader($lb);
    }
}

?>