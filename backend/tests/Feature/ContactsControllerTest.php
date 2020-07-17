<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use mysql_xdevapi\DatabaseObject;
use Tests\TestCase;

use App\Models\Contact;

class ContactsControllerTest extends TestCase
{
    // test which asserts that the put endpoint successfully returns the correct updated details
    public function testPutContact()
    {
        $updatedData = [
            'first_name' => 'Tommy',
            'last_name' => 'Henry',
            'email' => 'tommy@hotmail.com'
        ];
        $id = Contact::first()->uuid;
        $response = $this->json('PUT', "/api/contacts/$id", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => $updatedData
                ]
            ]);
    }
    // TODO: add test to ensure record actually in database
    // TODO: test that if only some fields provided, put will not update contact
    // TODO: add additional tests for POST, PATCH, DELETE methods

    // TODO split into seperate test cases with setup and  teardown methods to add and remove dummy data from database
    public function testBatchDelete()
    {
        // create a few dummy contacts to delete
        $data = [
            'first_name'=>'Test',
            'last_name'=>'Person',
            'email'=>'test@test.com'
        ];

        $c1 = Contact::create($data);
        $c2 = Contact::create($data);
        $c3 = Contact::create($data);
        $c4 = Contact::create($data);

        // confirm created contacts are in database and not deleted
        $this->assertDatabaseHas('contacts', ['uuid' => $c1->uuid, 'deleted_at' => null]);
        $this->assertDatabaseHas('contacts', ['uuid' => $c2->uuid, 'deleted_at' => null]);
        $this->assertDatabaseHas('contacts', ['uuid' => $c3->uuid, 'deleted_at' => null]);
        $this->assertDatabaseHas('contacts', ['uuid' => $c4->uuid, 'deleted_at' => null]);

        // delete first 3 contacts
        $response = $this->json('DELETE', "/api/contacts",[
            'ids' => "$c1->uuid,$c2->uuid,$c3->uuid"
        ]);

        // confirm response id 204 and confirm rows have been soft deleted
        $response->assertStatus(204);
        self::assertSoftDeleted('contacts',['uuid' => $c1->uuid]);
        self::assertSoftDeleted('contacts',['uuid' => $c2->uuid]);
        self::assertSoftDeleted('contacts',['uuid' => $c3->uuid]);

        // confirm if we try to delete already deleted items we get a 422
        $response = $this->json('DELETE', "/api/contacts",[
            'ids' => "$c1->uuid,$c2->uuid,$c3->uuid"
        ]);
        $response->assertStatus(422);

        // confirm if we try to delete a mix of existing and non-existing
        // contacts that 422 is returned and existing contacts are NOT deleted
        $response = $this->json('DELETE', "/api/contacts",[
            'ids' => "$c1->uuid,$c2->uuid,$c3->uuid,$c4->uuid"
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('contacts', ['uuid' => $c4->uuid, 'deleted_at' => null]);

        // confirm that if we not try to delete the individual item we get a 204
        // and contact is soft deleted
        $response = $this->json('DELETE', "/api/contacts",[
            'ids' => "$c4->uuid"
        ]);
        $response->assertStatus(204);
        $this->assertSoftDeleted('contacts', ['uuid' => $c4->uuid]);
    }
}
