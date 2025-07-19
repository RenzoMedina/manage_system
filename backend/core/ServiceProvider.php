<?php 

namespace Core;

use Flight;

class ServiceProvider{
    protected $db;
    public function __construct(){
        $this->db = Flight::get('db');
    }
}