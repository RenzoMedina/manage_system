<?php
require_once 'vendor/autoload.php';
$envPath = file_exists(__DIR__ . '/.env') ? __DIR__ : '/etc/secrets';
$dotenv = Dotenv\Dotenv::createImmutable($envPath);
$dotenv->load();
require_once 'app/Config/DataBase.php';
require_once 'routes/Api.php';