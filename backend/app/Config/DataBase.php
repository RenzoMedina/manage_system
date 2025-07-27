<?php 

namespace App\Config;
use Core\AppLog;
use Exception;
use Flight;
use Medoo\Medoo;
/**
 * ? ORM Medoo to connection a Database (MySQL, PostgreSQL, SQLite)
 */
try {
    $database = new Medoo([
        'type'=>$_ENV['DBTYPE'],
        'host'=>$_ENV['DBHOST'],
        'database' => $_ENV['DBNAME'],
        'username' => $_ENV['DBUSER'],
        'password' => $_ENV['DBPASS'],
        'error'=>\PDO::ERRMODE_EXCEPTION
        ]);
    //set Flight db to Medoo
    Flight::set('db',$database);
    AppLog::appLog("Database connection established successfully.");

} catch (Exception $e) {
    Flight::halt(500, json_encode([
        'error' => 'No se pudo conectar a la base de datos',
        'details' => $e->getMessage()
    ]));
}

