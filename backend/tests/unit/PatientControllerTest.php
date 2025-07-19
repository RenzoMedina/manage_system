<?php 

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\Attributes\Test;

class PatientControllerTest extends TestCase{

    #[Test]
    #[TestDox('Integration: Return Status Patient Create')]
    public function testPacientCreate(){
        $mock = new MockHandler([
            new Response(200,[], json_encode(['status '=> 200]))
        ]);
        $clientPatient = new Client(['handler'=>HandlerStack::create($mock)]);
        $request = $clientPatient->post(("/patient"),[
            "form_params"=>[
                'rut'=>"25.705.665-1",
                'name'=>"Renzo Steven",
                'last_name'=>"Medina Olaya",
                'age'=>34,
                'weigth'=>89.0,
                'size'=>1.75
            ]
        ]);
        $this->assertEquals(200,$request->getStatusCode());
    }

    public function testReturnPatient(){
        $mock = new MockHandler([
            new Response(200,[], json_encode(['status '=> 200]))
        ]);
        $clientPatient = new Client(['handler'=>HandlerStack::create($mock)]);
        $response = $clientPatient->get("/patient",[
            "data"=>[
                'id'=> 1,
                'rut'=> "25.705.665-1",
                'name' =>"Renzo Steven",
                'last_name' =>"Medina Olaya",
                'age' =>34,
                'weigth' => 90.0,
                'size' => 1.75,
                'status' => 'active',
                'created_at' => "2025-07-06 19:50:33",
                'updated_at' => "2025-07-06 19:50:33"
            ]
        ]);
        $this->assertJson(json_encode($response));
    }
}