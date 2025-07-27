<?php 

namespace App\Services;

use Flight;
use Exception;
use Core\ErrorLog;
use App\Utils\Pagination;
use Core\ServiceProvider;

class PatientService extends ServiceProvider{
    private $tableContact = "table_contacts_patients";
    private $tableDetailsClinical = "table_details_medicals";
    private $tableReport = "table_daily_report_of_patient";
    private $tableIntake = "table_intake_control_report_of_patient";
    private $tableExpense = "table_expense_control_report_of_patient";
    private $tableVital = "table_vital_signs_report_of_patient";
    private $tableOtherInstructions = "table_other_instructions_report_of_patient";
    private $tableDayEvaluations ="table_day_evaluation_report_of_patient";
    private $tableNightEvaluations ="table_night_evaluation_report_of_patient";
    public function contactOfPatient(int $idPatient, $data){
        try{
            $this->db->insert($this->tableContact,[
                "id_patient"=>$idPatient,
                "rut"=>$data->rut,
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                "relations"=>$data->relations,
                "telephone"=>$data->telephone,
            ]);
        }
        catch(Exception $e){
             ErrorLog::errorsLog($e->getMessage());
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);    
        }
    }

    public function updateContactOfPatient(int $idPatient,int $idContact, $data){
        try {
            $contact = $this->db->get($this->tableContact, '*', [
            'id' => $idContact,
            'id_patient' => $idPatient
             ]);

            if (!$contact) {
            Flight::jsonHalt(
                ['error' => 'Contact not found for the given patient ID'],
                 404);
            }
            $rowsAffected = $this->db->update($this->tableContact,[
                "rut"=>$data->rut,
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                "relations"=>$data->relations,
                "telephone"=>$data->telephone,
            ],[
                "id"=>$idContact
            ]);
            $rowsOk = $rowsAffected->rowCount();
            return $rowsOk > 0;
        } catch (Exception $e) {
             ErrorLog::errorsLog($e->getMessage());
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }

    public function detailsClinicalOfPatient(int $idPatient, $data){
        try{
            $this->db->insert($this->tableDetailsClinical,[
                "id_patient"=>$idPatient,
                "gttd"=>$data->gttd,
                "sng"=>$data->sng,
                "s_folley"=>$data->s_folley,
                "cit"=>$data->cit,
            ]);
        }
        catch(Exception $e){
             ErrorLog::errorsLog($e->getMessage());
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);    
        }
    }

    public function updateDetailsClinicalOfPatient(int $idPatient,$idContact, $data){
        try {
            $contact = $this->db->get($this->tableContact, '*', [
            'id' => $idContact,
            'id_patient' => $idPatient
             ]);

            if (!$contact) {
            Flight::jsonHalt(
                ['error' => 'Contact not found for the given patient ID'],
                 404);
            }
            $rowsAffected = $this->db->update($this->tableContact,[
                "rut"=>$data->rut,
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                "relations"=>$data->relations,
                "telephone"=>$data->telephone,
            ],[
                "id"=>$idContact
            ]);
            $rowsOk = $rowsAffected->rowCount();
            return $rowsOk > 0;
        } catch (Exception $e) {
             ErrorLog::errorsLog($e->getMessage());
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }

    public function createReport(int $idPatient, int $idUser, $data){
        try{    
            $this->db->insert($this->tableReport,[
                "id_patient"=> $idPatient,
                "observartions_global" => $data->observartions_global,
                "id_user"=>$idUser
            ]);
        }catch(Exception $e){
                 ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                    "error"=>$e->getMessage()
                    ],403); 
        }
    }

    public function createVitalSigns(int $idReport, $data){
        try{    
            $this->db->insert($this->tableVital,[
                "id_daily_report"=> $idReport,
                "schedule" => $data->schedule,
                "blood_pressure" => $data->blood_pressure,
                "respiratory_rate" => $data->respiratory_rate,
                "heart_rate" => $data->heart_rate,
                "saturation" => $data->saturation,
                "temperature" => $data->temperature,
                "eva_flacc"=>$data->eva_flacc
            ]);
        }catch(Exception $e){
                ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                    "error"=>$e->getMessage()
                    ],403); 
        }
    }
    public function createIntakeControl(int $idReport, $data){
        try{    
            $this->db->insert($this->tableIntake,[
                "id_daily_report"=> $idReport,
                "schedule" => $data->schedule,
                "type_food" => $data->type_food,
                "tolerance" => $data->tolerance
            ]);
        }catch(Exception $e){
                 ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                    "error"=>$e->getMessage()
                    ],403); 
        }
    }

    public function createExpenseControl(int $idReport, $data){
        try{    
            $this->db->insert($this->tableExpense,[
                "id_daily_report"=> $idReport,
                "schedule" => $data->schedule,
                "urine" => $data->urine,
                "deposition" => $data->deposition,
                "others" => $data->others,
                    ]);
        }catch(Exception $e){
                 ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                        "error"=>$e->getMessage()
                ],403); 
        }
    }

    public function createOtherInstructions(int $idReport, $data){
        try{    
            $this->db->insert($this->tableOtherInstructions,[
                "id_daily_report"=> $idReport,
                "schedule" => $data->schedule,
                "observations" => $data->observations,
                "frequency" => $data->frequency
                    ]);
        }catch(Exception $e){
                ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                        "error"=>$e->getMessage()
                ],403); 
        }
    }

    public function createDayEvalutions(int $idReport, $data){
        try{    
            $this->db->insert($this->tableDayEvaluations,[
                "id_daily_report"=> $idReport,
                "observations" => $data->observations
                    ]);
        }catch(Exception $e){
                ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                        "error"=>$e->getMessage()
                ],403); 
        }
    }

    public function createNightEvalutions(int $idReport, $data){
        try{    
            $this->db->insert($this->tableNightEvaluations,[
                "id_daily_report"=> $idReport,
                "observations" => $data->observations
                    ]);
        }catch(Exception $e){
                ErrorLog::errorsLog($e->getMessage());
                Flight::jsonHalt([
                        "error"=>$e->getMessage()
                ],403); 
        }
    }

    public function getReportByIdPatient(int $idPatient){
        try{
            $filtres = ["id_patient"=> $idPatient];
            $pagination = Pagination::paginateById($this->db, $this->tableReport,$filtres, "/api/v1/patient/report");
            $details = $pagination['data'];

            $result = [];
            foreach ($details as $detail) {
                $reportId = $detail['id'];
            $result[] = [
                "vital_signs" => $this->db->select($this->tableVital, '*', ["id_daily_report" => $reportId]),
                "intake_control" => $this->db->select($this->tableIntake, '*', ["id_daily_report" => $reportId]),
                "expense_control" => $this->db->select($this->tableExpense, '*', ["id_daily_report" => $reportId]),
                "other_instructions" => $this->db->select($this->tableOtherInstructions, '*', ["id_daily_report" => $reportId]),
                "day_evaluations" => $this->db->select($this->tableDayEvaluations, '*', ["id_daily_report" => $reportId]),
                "night_evaluations" => $this->db->select($this->tableNightEvaluations, '*', ["id_daily_report" => $reportId])
            ];
            }
            return [
                "data" => $result,
                "pagination" => $pagination['pagination']
            ];
        
        }catch(Exception $e){
            ErrorLog::errorsLog("401 -> Error fetching all patients: " . $e->getMessage());
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],401);
        }
    }
}