<?php 

namespace Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase{

    #[Test]
    #[TestDox("Return status with login User")]
    public function testLoginUser(){
        $client = new Client([
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
        
        $getRes = $client->get('/api/v1/user',[
                'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
                     ]
        ]);
        $body = json_encode($getRes->getBody()->getContents(), true);

        $this->assertEquals(200, $getRes->getStatusCode());
        $this->assertJson($body);
        var_dump($body);
        $this->assertEquals(200, $authResponse->getStatusCode());
    }
}