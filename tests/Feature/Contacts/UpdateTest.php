<?php

namespace Tests\Feature\Contacts;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('contactProvider')]
    public function testContactCanBeUpdated($contactData): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $contact = Contact::factory()->for($user, 'user')->create();

        $response = $this->put(route('dash.contacts.update', ['contact' => $contact->id]), $contactData);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contacts', [
            'cpf' => $contactData['cpf'],
        ]);
    }

    #[DataProvider('contactProvider')]
    public function testContactCanBeUpdatedViaApi($contactData)
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test');

        $this->actingAs($user);

        $contact = Contact::factory()->for($user, 'user')->create();

        $response = $this->json('PUT', route('api.contact.update', ['contact' => $contact->id]), $contactData, [
            'Authorization' => 'Bearer ' . $token->plainTextToken,
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contacts', [
            'cpf' => $contactData['cpf'],
        ]);
    }

    public static function contactProvider(): array
    {
        return [
            [
                [
                    'name'                 => 'Uex',
                    'email'                => 'financeiro@uex.io',
                    'phone'                => '41988142160',
                    'cpf'                  => '71641438037',
                    'address_cep'          => '80250104',
                    'address_uf'           => 'pr',
                    'address_city'         => 'curitiba',
                    'address_neighborhood' => 'batel',
                    'address_street'       => 'Rua Pasteur',
                    'address_number'       => '463',
                    'address_complement'   => 'Conj 1402 Cond Cd Ed Centro Empresa',
                    'latitude'             => -25.4437123,
                    'longitude'            => -49.2815662,
                ],
            ],
        ];
    }
}
