<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Clave actual siendo utilizada por el factory.
     */
    protected static ?string $password;

    /**
     * Definir el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => fake()->uuid(),
            "name" => fake()->name(),
            "email" => fake()->unique()->safeEmail(),
            "email_verified_at" => now(),
            "password" => (static::$password ??= Hash::make("password")),
            "remember_token" => Str::random(10),
        ];
    }

    /**
     * Indica que el email del modelo debe estar no verificado.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "email_verified_at" => null,
            ]
        );
    }
}
