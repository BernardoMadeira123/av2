<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Utils\CustomEncryption;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UserFactory extends Factory
{

    protected static ?string $password;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'senha' => static::$password ??= CustomEncryption::encrypt('senha123'), // Usando criptografia personalizada
        ];
    }

}
