<?php

namespace Tests\Unit;

// changed TestCase import so test will pass
use Tests\TestCase;
use App\Models\Contact;

class ContactModelTest extends TestCase
{
    public function testNewContactHasUuid()
    {
        $model = Contact::make();
        // Changed expected length to 36 and changed to assertEquals
        $this->assertEquals(36,strlen($model->uuid));
    }
}
