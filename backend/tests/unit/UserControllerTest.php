<?php 

namespace Tests\Unit;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

class UserControllerTest extends TestCase{
    #[Test]
    #[TestDox('Return Instance User')]
    public function returnInstanceUser(){
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    #[Test]
    #[TestDox('Store User')]
    public function storeUser(){
        $mock = new MockHandler([
            new Response(200,[], json_encode(['status '=> 200]))
        ]);
        $clientUser = new Client(['handler'=>HandlerStack::create($mock)]);
        $request = $clientUser->post("/user",[
            'form_params' => [
                'name'=>"Renzo",
                'last_name'=>"Medina",
                'email'=>"medinast30@mail.com",
                'password'=>"1234",
                'id_rol'=>01
                ]
            ]);

        $request->getBody();
        $this->assertEquals(200, $request->getStatusCode());
    }

    #[Test]
    #[TestDox('Get User')]
    public function testGetUser(){ 
        $mock = new MockHandler([
            new Response(200,[], json_encode(['status '=> 200]))
        ]);
        $clientUser = new Client(['handler'=>HandlerStack::create($mock)]);
        $request = $clientUser->get("/user",[
            "data"=> [
                "id"=> 1,
                "name"=>"Renzo",
                "last_name"=> "Medina",
                "email"=> "admin@sistemaadminsitrable.cl",
                "password"=> "12343",
                "id_rol"=>1,
                "status"=> "active",
                "created_at"=>"2025-07-06 19:50:33",
                "updated_at"=>"2025-07-06 19:50:33"
                ]
        ]);
        $data = json_encode($request->getBody(), true);
        $this->assertJson($data);
    }
}

