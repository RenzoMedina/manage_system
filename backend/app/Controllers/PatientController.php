<?php  

namespace App\Controllers;

use App\Models\Patient;
use App\Services\PatientService;
use Error;
use Flight;

class PatientController{
    
    public static function index(){
       
        Flight::json([
            "status"=>200,
            "data"=>(new Patient())->getAll()
        ]);
    }
    public static function show($id){
        $data = (new Patient())->getById($id);
        Flight::json([
            "status"=>200,
            "message"=>"Data loaded by {$id}",
            "data"=>$data
        ]);
    }

    public static function store(){
        $data = Flight::request()->data;
        (new Patient())->create($data);
        Flight::json([
            "status"=>201,
            "message"=>"Data load succesfully!!!",
            "data"=>$data
        ]);
    }  
    /**
     * ? update data of patient
     * @param int $id
     */
    public static function update($id){
        $data = Flight::request()->data;
        $success = (new Patient())->update($id,$data);
        if ($success){
            Flight::json([
                "status"=>200,
                "message"=>"Data updated by {$id}",
                "data"=>$data
            ]);
        }else{
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for patient with ID: {$id}");
        } 
    }
/*     public static function destroy($di){

    } */
    /**
     * ? store contact of patient
     * @param int $idPatient
     */
    public function storeContact($idPatient){
        $data = Flight::request()->data;
       (new PatientService())->contactOfPatient($idPatient,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Data load succesfully!!!",
            "data"=>$data,
            "id"=>$idPatient
        ]);
    }
    public static function updateContact($idPatient, $idContact){
        $data = Flight::request()->data;
        $success = (new PatientService())->updateContactOfPatient($idPatient, $idContact,$data);
        if ($success){
            Flight::json([
                "status"=>200,
                "message"=>"Data updated by {$idContact}",
                "data"=>$data
            ]);
        }else{
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for contact with ID: {$idContact} of patient with ID: {$idPatient}");
        } 
    }

    public function storeDetailsClinical($idPatient){
        $data = Flight::request()->data;
       (new PatientService())->detailsClinicalOfPatient($idPatient,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Data load succesfully!!!",
            "data"=>$data,
            "id"=>$idPatient
        ]);
    }

    public static function updateDetailClinical($idPatient, $idContact){
        $data = Flight::request()->data;
        $success = (new PatientService())->updateDetailsClinicalOfPatient($idPatient,$idContact,$data);
        if ($success){
            Flight::json([
                "status"=>200,
                "message"=>"Data updated by {$idContact}",
                "data"=>$data
            ]);
        }else{
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for contact with ID: {$idContact} of patient with ID: {$idPatient}");
        } 
    }
}