<?php 

namespace App\Utils;

use Flight;

class Cors{
    public static function set(array $params): void
    {
        $request = Flight::request();
        $response = Flight::response();
        if ($request->getVar('HTTP_ORIGIN') !== '') {
            self::allowOrigins();
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Max-Age', '86400');
        }

        if ($request->method === 'OPTIONS') {
            if ($request->getVar('HTTP_ACCESS_CONTROL_REQUEST_METHOD') !== '') {
                $response->header(
                    'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS, HEAD'
                );
            }
            if ($request->getVar('HTTP_ACCESS_CONTROL_REQUEST_HEADERS') !== '') {
                $response->header(
                    "Access-Control-Allow-Headers",
                    $request->getVar('HTTP_ACCESS_CONTROL_REQUEST_HEADERS')
                );
            }

            $response->status(200);
            $response->send();
            exit;
        }
    }

    private static function allowOrigins(): void
    {
        // personaliza tus hosts permitidos aquí.
        $allowed = [
            'capacitor://localhost',
            'ionic://localhost',
            'http://localhost',
            'http://localhost:4321',
            'http://localhost:8080',
            'http://localhost:8100',
        ];

        $request = Flight::request();

        if (in_array($request->getVar('HTTP_ORIGIN'), $allowed, true) === true) {
            $response = Flight::response();
            $response->header("Access-Control-Allow-Origin", $request->getVar('HTTP_ORIGIN'));
        }
    }
}