<?php 

use Core\ErrorLog;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Summary of getToken with JWT
 * @param mixed $data
 * @param mixed $admin
 * @return string
 */
function getToken($data,$admin){
    $now = strtotime("now");
    $key = $_ENV['TOKEN'];
    $payload = [
        'exp'=>$now + 3600,
        'rol'=>$admin,
        'data'=> $data
    ];
    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
}

/**
 * Summary of validatedToken 
 * @param mixed $token
 * @param mixed $key
 * later validated return token
 */
function validatedToken($token,$key){
    try {
        $decodeJWT = JWT::decode($token, new Key($key, 'HS256'));
        return $decodeJWT;
    } catch (ExpiredException $e) {
        ErrorLog::errorsLog("401 - Expired token: " . $e->getMessage());
        Flight::jsonHalt([
            "error"=>"Expired token",
            "details"=>$e->getMessage()
        ],401);
    }catch(Exception $e) {
        ErrorLog::errorsLog("401 - Invalid token: " . $e->getMessage());
        Flight::jsonHalt([
            "error"=>"Invalid token",
            "details"=>$e->getMessage()
        ],401);
    }
}