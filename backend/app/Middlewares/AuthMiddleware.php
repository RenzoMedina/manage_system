<?php 

namespace App\Middlewares;

use Core\AppLog;
use Core\ErrorLog;
use Flight;

class AuthMiddleware{

    public function before($params){
            $auth = Flight::request()->header('Authorization');
            AppLog::appLog("Authorization header received: " . $auth);
            if(!$auth){
                ErrorLog::errorsLog("Empty token received");
                Flight::jsonHalt([
                    "error"=>"Empty token"
                ], 401);
            }
            $token = trim(str_replace('Bearer',"",$auth));
            $admin = validatedToken($token, $_ENV['TOKEN']);

            if ($admin->rol != "Administrador"){
                ErrorLog::errorsLog("Access denied. Admin privileges required for user: {$admin->name}");
                Flight::jsonHalt([
                    "error"=>"Access denied. Admin privileges required"
                ], 401);
            }
            
    }
}