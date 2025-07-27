<?php 

namespace App\Services;

use Core\AppLog;
use Core\ServiceProvider;
use Flight;
use Core\ErrorLog;
use PharIo\Version\Exception;

class UserService extends ServiceProvider{

    public function loginUser($name, $field){
        try {
            $data =  $this->db->get('table_users',
            [
                '[><]table_roles' => ['id_rol' => 'id']
            ],
            [
                'table_users.id',
                'table_users.name',
                'table_users.password',
                'table_roles.type_role'
            ],
            [
                'table_users.name' => $name
            ]

            );
            
            $id = $data['id'];
            $id_rol = $data['type_role'];
            $user = $data['name'];
            $password = $data['password']; 
            
            if (password_verify($field->password,$password) && $user == $field->name){
                AppLog::appLog("User {$name} logged in successfully.");
                return getToken( $id,$id_rol);
            }
            else{
                ErrorLog::errorsLog("401 -> Invalid login attempt for user: {$name}");
                Flight::jsonHalt([
                    "error"=>"Invalid username or password"
                ],401);
            }
        } catch (Exception $e) {
            ErrorLog::errorsLog("401 -> Invalid login attempt for user: {$name} - " . $e->getMessage());
            Flight::jsonHalt([
                    "error"=>"Invalid login",
                    "details"=>$e->getMessage()
                ],401);
            }
    }
}