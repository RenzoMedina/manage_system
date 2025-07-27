<?php 

namespace App\Models;

use Core\AppLog;
use Flight;
use Exception;
use Core\Model;
use Core\ErrorLog;
use App\Utils\Pagination;

class Patient extends Model{
    
    /**
     * Summary of table
     * @var string
     */
    private $table = "table_patients";
    public function getAll(){
        try{
            $patients = $this->db->select($this->table, '*');
            $pagination = Pagination::paginate($this->db, $this->table);
            $patients = $pagination['data'];

            $result = [];
            foreach ($patients as $patient) {
                $contacts = $this->db->select("table_contacts_patients", '*', [
                    "id_patient" => $patient['id']
                ]);
                $detailsClinical = $this->db->select("table_details_medicals", '*', [
                    "id_patient" => $patient['id']
                ]);
                $result[] = [
                    "patient" => $patient,
                    "contacts" => $contacts,
                    "detailsClinical" => $detailsClinical
                ];
            }
            AppLog::appLog("Fetched all patients successfully.");
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
    /**
     * Summary of create
     * @param mixed $data
     * @return void
     */
    public function create($data){
        try {
            $this->db->insert($this->table,[
                "rut"=>$data->rut,
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                "age"=>$data->age,
                "weigth"=>$data->weigth,
                "size"=>$data->size
            ]);
            AppLog::appLog("Patient created successfully with ID: " . $this->db->id());
        } catch (Exception $e) {
            ErrorLog::errorsLog("403 -> Error creating patient: " . $e->getMessage());
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }

    /**
     * Summary of getById
     * @param int $id
     * @return array|null
     */
    public function getById(int $id){
        try {
        $patient = $this->db->get($this->table, '*', [
            "id" => $id
        ]);
        if (!$patient) {
            throw new Exception("Patient not found");
        }
        $contacts = $this->db->select("table_contacts_patients", '*', [
            "id_patient" => $patient['id']
        ]);

        $detailsClinical = $this->db->select("table_details_medicals", '*', [
            "id_patient" => $patient['id']
        ]);
        AppLog::appLog("Fetched patient by ID: " . $id);
        return [
                "patient" => $patient,
                "contacts" => $contacts,
                "detailsClinical" => $detailsClinical
        ];
    } catch (Exception $e) {
        ErrorLog::errorsLog("403 -> Error fetching patient by ID: " . $e->getMessage());
        Flight::jsonHalt([
            "error" => $e->getMessage()
        ], 403);
    }
    }

    public function update(int $id, $data){
        try {
            $rowsAffected = $this->db->update($this->table,[
                "rut"=>$data->rut,
                "name"=>$data->name,
                "last_name"=>$data->last_name,
                "age"=>$data->age,
                "weigth"=>$data->weigth,
                "size"=>$data->size,
                "status"=>$data->status,
            ],[
                "id"=>$id
            ]);
            $rowsOk = $rowsAffected->rowCount();
            AppLog::appLog("Patient with ID: {$id} updated successfully. Rows affected: {$rowsOk}");
            return $rowsOk > 0;
        } catch (Exception $e) {
            ErrorLog::errorsLog("403 -> Error updating patient with ID: {$id} - " . $e->getMessage());
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }
}