<?php 

namespace App\Controllers;

use App\Models\Role;
use Flight;

class RoleController{

    public static function index(){
        $data = (new Role())->getAll();
        Flight::json([
            "data"=> $data
        ]);
    }
    public static function store(){
        $type_role = Flight::request()->data->type_role;
        $data = (new Role())->create($type_role);
        Flight::json([
                "status"=>200,
                "message"=>"Role created successfully!!",
                "id"=> $data
            ]);
        
    }
    public static function update($id){}
    public static function destroy($id){

    }
}