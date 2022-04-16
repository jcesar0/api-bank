<?php

namespace Http\Controllers\v1\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanRegister()
    {
        $payload = [
            'name' => 'John Doe',
            'cpf' => '111.111.111-11',
            'password' => 'senhapoderosa',
            'account_type' => 'CHECKING',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'cpf' => '11111111111',
            'name' => $payload['name']
        ]);
    }

    public function testUserCannotHaveAccountNumberReceivedFromPayload()
    {
        $payload = [
            'name' => 'John Doe',
            'cpf' => '111.111.111-11',
            'password' => 'senhapoderosa',
            'account_type' => 'CHECKING',
            'account_number' => '123456789'
        ];

        $response = $this->post(route('register'), $payload);
        $contents = json_decode($response->getContent(), true);

        $response->assertStatus(201);
        $this->assertDatabaseMissing('users', [
            'cpf' => $payload['cpf'],
            'name' => $payload['name'],
            'account_number' => $payload['account_number'],
        ]);
        $this->assertNotEquals($payload['account_number'], $contents['user']['account_number']);
    }
}
