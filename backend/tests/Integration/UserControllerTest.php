<?php 

namespace Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase{

    #[Test]
    #[TestDox("Return status with login User")]
    public function testLoginUser(){
        $this->markTestIncomplete('Test ignorado temporalmente hasta que se resuelva el token');

       /*  $client = new Client([
            'base_uri'=>'http://app',
            'timeout' => 5.0
        ]);
        $authResponse = $client->post('/login',[
            'json'=>[
                "name" => "Admin",
                "password" => "adminMain"
            ]
        ]);
        $autData = json_decode($authResponse->getBody(), true);
        $token = $autData['token'] ?? null ;
        $this->assertNotNull($token, "No token was received");
        $this->assertEquals(200, $authResponse->getStatusCode()); */
    }
}