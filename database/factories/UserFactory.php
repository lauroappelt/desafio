<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Uuid::uuid4(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'identifier' => fake('pt_BR')->cpf(),
            'password' => static::$password ??= Hash::make('password'),
            'user_type' => User::USER_COMMON,
        ];
    }
}
