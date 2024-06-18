<?php

namespace Tests\Feature\Contacts;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testAssertContactsListCanBeRetrieved(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        Contact::factory(50)->for($user, 'user')->create();

        $response = $this->json(
            'GET',
            route('api.contact.index'),
            headers: [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(['data' => [
            'pagination',
            'items',
        ]]);

        $responseData = json_decode($response->content(), true)['data'];

        $this->assertArrayHasKey('items', $responseData);

        $this->assertCount(50, $responseData['items']);
    }

    public function testAssertOnlyUserContactsAreRetrieved(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $contacts = Contact::factory(50)->for($user, 'user')->create()->toArray();
        Contact::factory(50)->for(User::factory()->create(), 'user')->create();

        $response = $this->json(
            'GET',
            route('api.contact.index'),
            headers: [
                'Authorization' => 'Bearer ' . $token,
            ]
        );

        $response->assertJsonStructure(['data' => [
            'pagination',
            'items',
        ]]);

        $responseData = json_decode($response->content(), true)['data'];

        $this->assertArrayHasKey('items', $responseData);

        $this->assertArrayIsEqualToArrayIgnoringListOfKeys($contacts, $responseData['items'], array_keys($contacts));
    }
}
