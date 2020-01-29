<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Contact;

class ContactModelTest extends TestCase
{
    public function testNewContactHasUuid()
    {
        $model = Contact::make();
        $this->assertTrue(strlen($model->uuid) === 37);
    }
}
