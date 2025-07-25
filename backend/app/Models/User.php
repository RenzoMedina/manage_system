<?php 

namespace App\Models;

use Core\ErrorLog;
use Core\Model;
use Exception;
use Flight;

class User extends Model{
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

