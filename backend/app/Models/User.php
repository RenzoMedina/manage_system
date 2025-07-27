<?php 

namespace App\Models;

use Core\AppLog;
use Core\ErrorLog;
use Core\Model;
use Exception;
use Flight;

class User extends Model{
    public function getAll(){
        AppLog::appLog("Fetching all users");
        return $this->db->select('table_users','*');
    }
    public function getId($id){
        AppLog::appLog("Fetching user by ID: " . $id);
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
        AppLog::appLog("User created successfully with ID: " . $this->db->id());
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
            AppLog::appLog("User with ID: {$id} updated successfully. Rows affected: {$rowsOk}");
            return $rowsOk > 0;
        } catch (Exception $e) {
            ErrorLog::errorsLog("403 -> Error updating user with ID: {$id} - " . $e->getMessage());
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }
    public function delete(){}

}

