<?php

namespace Http\Controllers\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanAuthenticate()
    {
        $payload = [
            'cpf' => '11111111111',
            'password' => 'senhapoderosa'
        ];

        User::factory()->create($payload);

        $response = $this->post(route('login'), $payload);

        $userId = json_decode($response->getContent(), true)['user']['id'];

        $response->assertStatus(200);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $userId,
        ]);
    }

    public function testUserTryAuthenticateInvalidCredentials()
    {
        $payload = [
            'cpf' => '11111111111',
            'password' => 'senhapoderosa'
        ];

        User::factory()->create($payload);

        $response = $this->post(route('login'), [
            'cpf' => '11111111111',
            'password' => 'senhaerrada'
        ]);

        $response->assertStatus(401);
    }
}
