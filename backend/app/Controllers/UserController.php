<?php

namespace App\Controllers;

use App\Models\User;
use Core\ErrorLog;
use Exception;
use Flight;

class UserController{

    protected $user;
    public function __construct(){
        $this->user = new User();
    }
    public function index(){
        $data = (new User())->getAll();
        Flight::json([
            "data"=>$data
        ]);
    }

    public function show($id){
        Flight::json([
            "status"=>200,
            "message"=>"route show id {$id}",
            "env"=>$_ENV['DBNAME']
        ]);
    }

    public function login(){
        $user = Flight::request()->data->name;
        $field = Flight::request()->data;
        $token = $this->user->loginUser($user, $field);
        Flight::json([
            "token"=>$token,
        ]);
    }
    public function store(){

        try {
        $data = Flight::request()->data;
        $field_data = $data->getData();   
        $hash_pass = password_hash($data->password, PASSWORD_DEFAULT);
        $data->password = $hash_pass;

        if (empty($field_data)){
            Flight::jsonHalt([
            "error"=>"Field data is empty"
            ],401);
            ErrorLog::errorsLog("401 -> Field data is empty");
        }

        (new User())->create($data);
        Flight::json([
            "status"=>201,
            "data"=>$data
            ]);
        } catch (Exception $e) {
            Flight::jsonHalt([
            "error"=>"Unexpected error",
            "details"=>$e->getMessage()
            ],500);
            ErrorLog::errorsLog("Unexpected error: " . $e->getMessage());
        }
    }
    public function update(){}

    public function validateProfile(){
        $heades = getallheaders();
        $auth = isset($heades['Authorization']) ? $heades['Authorization'] : null;

        if(!$auth ||!str_starts_with($auth, 'Bearer ') ){
            Flight::jsonHalt([
            "error"=>"Token not sent!!",
            ],401);
            ErrorLog::errorsLog("401 -> Token not sent!!");
        }
        $token = substr($auth,7);

        try{
            $decode = validatedToken($token,$_ENV['TOKEN']);
            Flight::json([
                "token"=>$token,
                "validated"=>true,
                "rol"=>$decode->rol
            ]);
        } catch(Exception $e){
            Flight::jsonHalt([
                        "error"=>"Token invalid!!",
                        "details"=>$e->getMessage()
                ],500);
            ErrorLog::errorsLog("401 Token invalid!!: " . $e->getMessage());
        }
    }

}