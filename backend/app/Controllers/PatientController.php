<?php  

namespace App\Controllers;

use Flight;
use Core\AppLog;
use Core\ErrorLog;
use App\Models\Patient;
use App\Services\PatientService;

class PatientController{
    
    public static function index(){
       
        Flight::json([
            "status"=>200,
            "data"=>(new Patient())->getAll()
        ]);
        AppLog::appLog("Data loaded all patients");
    }
    public static function show($id){
        $data = (new Patient())->getById($id);
        Flight::json([
            "status"=>200,
            "message"=>"Data loaded by {$id}",
            "data"=>$data
        ]);
        AppLog::appLog("Data loaded by {$id}");
    }

    public static function store(){
        $data = Flight::request()->data;
        (new Patient())->create($data);
        Flight::json([
            "status"=>201,
            "message"=>"Data load succesfully!!!",
            "data"=>$data
        ]);
        AppLog::appLog("Data load succesfully!!! for patient with ID: {$data['id']}");
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
            AppLog::appLog("Data updated by {$id}");
        }else{
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for patient with ID: {$id}");
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
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
        AppLog::appLog("Data load succesfully!!! for patient with ID: {$idPatient}");
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
            AppLog::appLog("Data updated by {$idContact} for patient with ID: {$idPatient}");
        }else{
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for contact with ID: {$idContact} of patient with ID: {$idPatient}");
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
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
        AppLog::appLog("Data load succesfully!!! for patient with ID: {$idPatient}");
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
            AppLog::appLog("Data updated by {$idContact} for patient with ID: {$idPatient}");
        }else{
            ErrorLog::errorsLog("409 -> Data update has not been carried out validate id for contact with ID: {$idContact} of patient with ID: {$idPatient}");
            Flight::jsonHalt([
                "error"=>"Data update has not been carried out validate id"
            ], 409);
        } 
    }

    public function reportDaily(int $idPatient, int $idUser){
        $data = Flight::request()->data;
       (new PatientService())->createReport($idPatient,$idUser,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report create succesfully!!!",
            "data"=>$data,
            "id_patient"=>$idPatient,
            "id_user"=>$idUser
        ]);
        AppLog::appLog("Report create succesfully!!! for patient with ID: {$idPatient} and user ID: {$idUser}");
    }
    public function vitalSigns(int $idPatient, int $idReport){
        $data = Flight::request()->data;
        (new PatientService())->createVitalSigns($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Vital Signs create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
        AppLog::appLog("Report Vital Signs create succesfully!!! for patient with ID: {$idPatient} and report ID: {$idReport}");
    }
    public function intakeControl(int $idPatient, int $idReport){
        $data = Flight::request()->data;
        (new PatientService())->createIntakeControl($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Intake create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
        AppLog::appLog("Report Intake create succesfully!!! for patient with ID: {$idPatient} and report ID: {$idReport}");
    }
    public function expenseControl(int $idPatient, int $idReport){
         $data = Flight::request()->data;
        (new PatientService())->createExpenseControl($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Expense create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
        AppLog::appLog("Report Expense create succesfully!!! for patient with ID: {$idPatient} and report ID: {$idReport}");
    }

     public function othersInstructions(int $idPatient, int $idReport){
         $data = Flight::request()->data;
        (new PatientService())->createOtherInstructions($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Others Instructions create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
    }

    public function dayEvaluations(int $idPatient, int $idReport){
         $data = Flight::request()->data;
        (new PatientService())->createDayEvalutions($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Day evaluations create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
        AppLog::appLog("Report Day evaluations create succesfully!!! for patient with ID: {$idPatient} and report ID: {$idReport}");
    }

    public function nightEvaluations(int $idPatient, int $idReport){
        $data = Flight::request()->data;
        (new PatientService())->createNightEvalutions($idReport,$data);
        Flight::json([
            "status"=>201,
            "message"=>"Report Day evaluations create succesfully!!!",
            "data"=>$data,
            "id_daily_report"=>$idReport,
            "id_patient"=>$idPatient
        ]);
        AppLog::appLog("Report Night evaluations create succesfully!!! for patient with ID: {$idPatient} and report ID: {$idReport}");
    }

    public function getReportById(int $idPatient){
         $data = (new PatientService())->getReportByIdPatient($idPatient);
        Flight::json([
            "status"=>200,
            "message"=>"Data report by id Patient {$idPatient}",
            "content"=>$data
        ]);
        AppLog::appLog("Data report by id Patient {$idPatient}");
    }
}