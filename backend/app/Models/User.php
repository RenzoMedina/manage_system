<?php 

namespace App\Models;

use Core\ErrorLog;
use Core\Model;
use Exception;
use Flight;

class User extends Model{
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
    public function getAll(){
        return $this->db->select('table_users','*');
    }
    public function getId($id){
        return $this->db->get('table_users','*',['id'=>$id]);
    }
    public function create($data){
        $this->db->insert('table_users',[
            'name'=>$data->name,
            'rut'=>$data->rut,
            'last_name'=>$data->last_name,
            'email'=>$data->email,
            'password'=>$data->password,
            'id_rol'=>$data->id_rol
        ]);
    }
    public function update(int $id, $data){
         try {
            $rowsAffected = $this->db->update('table_users',[
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                'password'=>$data->password,
                'id_rol'=>$data->id_rol,
                "status"=>$data->status,
            ],[
                "id"=>$id
            ]);
            $rowsOk = $rowsAffected->rowCount();
            return $rowsOk > 0;
        } catch (Exception $e) {
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
            ErrorLog::errorsLog("403 -> Error updating user with ID: {$id} - " . $e->getMessage());
        }
    }
    public function delete(){}

}

