<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserService;
use Core\AppLog;
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
        AppLog::appLog("Data loaded all users");
    }

    public function show(int $id){
        try{
            $data = (new User())->getId($id);
            if ($id != $data['id'] || empty($data) || !isset($data) || !is_numeric($id)){
                Flight::jsonHalt([],404);
            }
            Flight::json([
                "message"=>"Data user with ID: {$id}",
                "data"=>$data
            ]);
            AppLog::appLog("Data loaded by ID: {$id}");
        }catch(Exception $e){
             ErrorLog::errorsLog("404 -> User not found or data is empty or id: {$id} not valid - " . $e->getMessage());
            Flight::jsonHalt([
                "error"=>"User not found or data is empty or id not valid",
                "details"=>$e->getMessage(),
               
            ],404);
            
        }
    }

    public function login(){
        $user = Flight::request()->data->name;
        $field = Flight::request()->data;
        $token = (new UserService())->loginUser($user,$field);
        Flight::json([
            "token"=>$token,
        ]);
        AppLog::appLog("User logged in with name: {$user}");
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
            AppLog::appLog("User created successfully with ID: {$data->id}");
        } catch (Exception $e) {
            ErrorLog::errorsLog("Unexpected error: " . $e->getMessage());
            Flight::jsonHalt([
            "error"=>"Unexpected error",
            "details"=>$e->getMessage()
            ],500);
           
        }
    }
    public function update(int $id){
        $data = Flight::request()->data;
        $success = (new User())->update($id,$data);
        if ($success){
            Flight::json([
                "status"=>200,
                "message"=>"Data updated by {$id}",
                "data"=>$data
            ]);
            AppLog::appLog("Data updated by ID: {$id}");
        }else{
             ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for users with ID: {$id}");
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
           
        } 
    }

    public function validateProfile(){
        $heades = getallheaders();
        $auth = isset($heades['Authorization']) ? $heades['Authorization'] : null;

        if(!$auth ||!str_starts_with($auth, 'Bearer ') ){
            ErrorLog::errorsLog("401 -> Token not sent!!");
            Flight::jsonHalt([
            "error"=>"Token not sent!!",
            ],401);
           
        }
        $token = substr($auth,7);

        try{
            $decode = validatedToken($token,$_ENV['TOKEN']);
            Flight::json([
                "token"=>$token,
                "validated"=>true,
                "rol"=>$decode->rol
            ]);
            AppLog::appLog("Token validated successfully for user: {$decode->rol}");
        } catch(Exception $e){
            ErrorLog::errorsLog("401 Token invalid!!: " . $e->getMessage());
            Flight::jsonHalt([
                        "error"=>"Token invalid!!",
                        "details"=>$e->getMessage()
                ],500);
            
        }
    }

}