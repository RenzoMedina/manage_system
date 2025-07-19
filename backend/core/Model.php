<?php 

namespace Core;

use Flight;

abstract class Model {
    protected $db;
    public function __construct(){
        $this->db = Flight::get('db');
    }
}