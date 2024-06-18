<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                 => $this->faker->name,
            'email'                => $this->faker->email,
            'phone'                => random_int(11111111111, 99999999999),
            'cpf'                  => random_int(11111111111, 99999999999),
            'latitude'             => $this->faker->latitude(),
            'longitude'            => $this->faker->longitude(),
            'address_cep'          => random_int(11111111, 99999999),
            'address_uf'           => $this->faker->randomLetter() . $this->faker->randomLetter(),
            'address_city'         => $this->faker->city(),
            'address_neighborhood' => $this->faker->streetName(),
            'address_street'       => $this->faker->streetName(),
            'address_number'       => random_int(11111, 99999),
            'address_complement'   => random_int(0, 1) ? $this->faker->word() : null,
        ];
    }
}
