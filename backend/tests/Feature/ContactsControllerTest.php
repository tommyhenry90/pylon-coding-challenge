<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Contact;

class ContactTest extends TestCase
{
    public function testCreateContact()
    {
        $response = $this->json('POST', "/api/contacts", [
            'first_name' => 'Tommy',
            'last_name' => 'Henry',
            'email' => 'tommy.henry@5b.com.au'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'first_name' => 'Tommy',
                        'last_name' => 'Henry'
                    ]
                ]
            ]);
    }
}
