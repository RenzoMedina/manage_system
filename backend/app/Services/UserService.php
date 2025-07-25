<?php 

namespace App\Services;

use Flight;
use Core\Model;
use Core\ErrorLog;
use PharIo\Version\Exception;

class UserService extends Model{

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
                return getToken( $id,$id_rol);
            }
            else{
                Flight::jsonHalt([
                    "error"=>"Invalid username or password"
                ],401);
                ErrorLog::errorsLog("401 -> Invalid login attempt for user: {$name}");
            }
        } catch (Exception $e) {
            Flight::jsonHalt([
                    "error"=>"Invalid login",
                    "details"=>$e->getMessage()
                ],401);
                ErrorLog::errorsLog("401 -> Invalid login attempt for user: {$name} - " . $e->getMessage());
            }
    }
}