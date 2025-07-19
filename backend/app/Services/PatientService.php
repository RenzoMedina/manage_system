<?php 

namespace App\Services;

use Flight;
use Core\ServiceProvider;

class PatientService extends ServiceProvider{
    private $tableContact = "table_contacts_patients";
    private $tableDetailsClinical = "table_details_medicals";
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
        catch(\Exception $e){
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
        } catch (\Exception $e) {
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
        catch(\Exception $e){
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
        } catch (\Exception $e) {
             Flight::jsonHalt([
                "error"=>$e->getMessage()
            ],403);
        }
    }
}