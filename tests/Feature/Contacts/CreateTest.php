<?php

namespace Tests\Feature\Contacts;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('contactProvider')]
    public function testContactsCanBeCreated(array $contactData): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('dash.contacts.store'), $contactData);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('dash.contacts.index'));

        $response->assertSessionHas('flash', [
            'type'    => 'success',
            'message' => __('messages.contacts.created'),
        ]);

        $this->assertDatabaseHas('contacts', [
            'cpf' => '71641438037',
        ]);
    }

    #[DataProvider('contactProvider')]
    public function testContactsCantBeCreatedWithInvalidData(array $contactData): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $contactData['cpf']   = '12345678910';
        $contactData['phone'] = '1';
        $contactData['email'] = '1';

        $response = $this->post(route('dash.contacts.store'), $contactData);

        $response->assertSessionHasErrors([
            'cpf',
            'phone',
            'email',
        ]);
    }

    #[DataProvider('contactProvider')]
    public function testContactsCanBeCreatedViaAPI(array $contactData): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test');

        $response = $this->json(
            'POST',
            route('api.contact.store'),
            $contactData,
            [
                'Authorization' => 'Bearer ' . $token->plainTextToken,
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas('contacts', [
            'cpf' => '71641438037',
        ]);
    }

    #[DataProvider('contactProvider')]
    public function testAssertAContactWithSameCPFCanBeCreatedForDifferentUsers(array $contactData): void
    {
        $user   = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(
            route('api.contact.store'),
            $contactData,
        );

        $user2 = User::factory()->create();

        $this->actingAs($user2);

        $response = $this->post(
            route('api.contact.store'),
            $contactData,
        );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contacts', [
            'cpf'     => '71641438037',
            'user_id' => $user2->id,
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
