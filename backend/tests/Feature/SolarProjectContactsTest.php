<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\SolarProject;
use App\Models\Contact;

class SolarProjectContactsTest extends TestCase
{
    public function testRemoveContacts()
    {
        $id = SolarProject::first()->uuid;

        $response = $this->json('PUT', "/api/solar_projects/$id/contacts", [
            'data' => [],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => [
                    'total' => 0,
                ],
            ]);

        $this->assertDatabaseMissing('contact_solar_project', [
            'solar_project_id' => SolarProject::first()->id,
        ]);
    }

    public function testConnectFirstContact()
    {
        $id = SolarProject::first()->uuid;
        $contactId = Contact::first()->uuid;

        $response = $this->json('PUT', "/api/solar_projects/$id/contacts", [
            'data' => [
                [
                    'type' => 'contacts',
                    'id' => $contactId,
                ],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'type' => 'contacts',
                        'id' => $contactId,
                    ],
                ],
                'meta' => [
                    'total' => 1,
                ],
            ]);

        $this->assertDatabaseHas('contact_solar_project', [
            'contact_id' => Contact::first()->id,
            'solar_project_id' => SolarProject::first()->id,
        ]);
    }
}
