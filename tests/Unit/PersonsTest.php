<?php
namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Phonenumber;

class PersonsTest extends TestCase
{
    /**
     * @group persons
     * @group persons-unit
     */
    public function test_can_add_contact_with_name_and_phone_number()
    {
        $contact = User::factory()
            ->has(Phonenumber::factory()->count(1))
            ->create();
        //dd($contact);
        $this->assertNotNull($contact);
        $this->assertGreaterThan(0, $contact->id);
        $this->assertIsString($contact->name);

        $this->assertNotNull($contact->phonenumbers);
        $this->assertGreaterThan(0, $contact->phonenumbers->count());
    }
}
