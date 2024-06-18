<?php

namespace Tests\Feature\Contacts;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testAssertAContactCanBeDeleted(): void
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->for($user, 'user')->create();

        $this->actingAs($user);

        $response = $this->delete(route('api.contact.delete', ['contact' => $contact->id]));

        $response->assertSessionDoesntHaveErrors();

        $response->assertStatus(200);

        $this->assertDatabaseMissing('contacts', [
            'cpf' => $contact->cpf,
        ]);
    }

    public function testAssertAContactCanBeDeletedViaAPI(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test');

        $contact = Contact::factory()->for($user, 'user')->create();

        $this->actingAs($user);

        $response = $this->json(
            'DELETE',
            route('api.contact.delete', ['contact' => $contact->id]),
            headers: [
                'Authorization' => 'Bearer ' . $token->plainTextToken,
            ]
        );

        $response->assertSessionDoesntHaveErrors();

        $response->assertStatus(200);

        $this->assertDatabaseMissing('contacts', [
            'cpf' => $contact->cpf,
        ]);
    }

    public function testAssertOnlyContactOwnerCanDeleteAContact()
    {
        $contact = Contact::factory()->for(User::factory()->create(), 'user')->create();

        $user2 = User::factory()->create();

        $this->actingAs($user2);

        $response = $this->delete(route('api.contact.delete', ['contact' => $contact->id]));

        // $response->assertStatus(403);
        // as we are using a global scope querying by the authenticated user on Contact's model, it throws an 404 error
        $response->assertStatus(404);

        $this->assertDatabaseHas('contacts', [
            'cpf' => $contact->cpf,
        ]);
    }
}
