<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        Contact::make()->create([
            'name'                 => 'Uex',
            'email'                => 'financeiro@uex.io',
            'phone'                => '41988142160',
            'cpf'                  => '12345678910',
            'address_cep'          => '80250104',
            'address_uf'           => 'pr',
            'address_city'         => 'curitiba',
            'address_neighborhood' => 'batel',
            'address_street'       => 'Rua Pasteur',
            'address_number'       => '463',
            'address_complement'   => 'Conj 1402 Cond Cd Ed Centro Empresa',
            'latitude'             => -25.4437123,
            'longitude'            => -49.2815662,
            'user_id'              => $user->id,
        ]);
    }
}
