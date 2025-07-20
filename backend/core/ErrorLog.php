<?php 

namespace Core;

class ErrorLog{

    private static $path = __DIR__. "/logs/";
    public static function errorsLog($log){
        if (!is_dir(self::$path)) {
            mkdir(self::$path, 0777, true);
        }
        $filePaht = self::$path . '/errors.log';
        $file = fopen($filePaht, "a");
        if($file){
            $time = date("Y-m-d H:i:s");
            fwrite($file, "[$time] $log\n");
            fclose($file);

        }else{
            echo "File not opened";
        }
    }
}