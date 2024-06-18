<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GetCepAddressTest extends TestCase
{
    #[DataProvider('cepProvider')]
    public function testAssertCanGetAddressFromACepAddress($cepData): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test');

        $response = $this->json(
            'GET',
            route('api.get-cep-address', ['cep' => $cepData['cep']]),
            headers: [
                'Authorization' => 'Bearer ' . $token->plainTextToken,
            ]
        );

        $response->assertStatus(200);

        $response->assertJson([
            'street'       => $cepData['street'],
            'neighborhood' => $cepData['neighborhood'],
            'city'         => $cepData['city'],
            'state'        => $cepData['state'],
        ]);
    }

    public static function cepProvider(): array
    {
        return [
            [
                [
                    'cep' => '29902052',

                    'street'       => 'Avenida Prefeito Manoel Salustiano de Souza',
                    'neighborhood' => 'Novo Horizonte',
                    'city'         => 'Linhares',
                    'state'        => 'ES',
                ],

                [
                    'cep'          => '57270972',
                    'street'       => 'Distrito Barro Vermelho, s/n',
                    'neighborhood' => 'Centro',
                    'city'         => 'Barro Vermelho',
                    'state'        => 'AL',
                ],
            ],
        ];
    }
}
