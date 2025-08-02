<?php
require_once 'vendor/autoload.php';
$envPath = '/etc/secrets/.env';
if (!file_exists($envPath)) {
    $envPath = __DIR__ . '/.env';
}

if (file_exists($envPath)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname($envPath), basename($envPath));
    $dotenv->load();
}

require_once 'app/Config/DataBase.php';
require_once 'routes/Api.php';