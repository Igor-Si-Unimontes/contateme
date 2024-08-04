<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contatos>
 */
class ContatosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'telefone' => $this->faker->phoneNumber,
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'imagem' => $this->faker->imageUrl(640, 480, 'animals', true, 'Faker'),
        ];
    }
}
