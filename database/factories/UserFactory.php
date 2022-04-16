<?php

namespace Database\Factories;

use App\Enums\AccountType;
use App\Support\Generate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => (string) random_int(11111111111, 99999999999),
            'password' => 'senhapoderosa',
            'account_number' => Generate::generateAccountNumber(),
            'account_type' => array_rand(array_column(AccountType::cases(), 'value')),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
