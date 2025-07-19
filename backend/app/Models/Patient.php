<?php 

namespace App\Models;

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
            return [
                "data" => $result,
                "pagination" => $pagination['pagination']
            ];
        
        }catch(Exception $e){
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],401);
            ErrorLog::errorsLog("401 -> Error fetching all patients: " . $e->getMessage());
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
        } catch (Exception $e) {
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
            ErrorLog::errorsLog("403 -> Error creating patient: " . $e->getMessage());
        }
    }

    /**
     * Summary of getById
     * @param int $id
     * @return array|null
     */
    public function getById(int $id){
        try {
            return $this->db->get($this->table,'*',[
            "id"=>$id
            ]);
        } catch (Exception $e) {
            Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
            ErrorLog::errorsLog("403 -> Error fetching patient by ID: " . $e->getMessage());
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
            return $rowsOk > 0;
        } catch (Exception $e) {
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
            ErrorLog::errorsLog("403 -> Error updating patient with ID: {$id} - " . $e->getMessage());
        }
    }
}