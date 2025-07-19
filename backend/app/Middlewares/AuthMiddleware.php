<?php 

namespace App\Middlewares;

use Flight;

class AuthMiddleware{

    public function before($params){
            $auth = Flight::request()->header('Authorization');
            if(!$auth){
                Flight::jsonHalt([
                    "error"=>"Empty token"
                ], 401);
            }
            $token = trim(str_replace('Bearer',"",$auth));
            $admin = validatedToken($token, $_ENV['TOKEN']);

            if ($admin->admin != "Administrador"){
                Flight::jsonHalt([
                    "error"=>"Access denied. Admin privileges required"
                ], 401);
            }
            
    }
}