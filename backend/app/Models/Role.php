<?php 

namespace App\Models;

use Core\AppLog;
use Core\Model;

class Role extends Model{
    public function create($data){
       $this->db->insert('table_roles',[
            'type_role'=>$data,
        ]);
        $roleId = $this->db->id();
        AppLog::appLog("Role created successfully with ID: " . $roleId);
        return $roleId;
    }

    public function getAll(){
        AppLog::appLog("Fetching all roles");
        return $this->db->select('table_roles','*');
    }
}