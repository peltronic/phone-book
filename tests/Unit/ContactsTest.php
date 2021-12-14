<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use App\Models\Phonenumber;

class PersonsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group unit
     * @group contacts
     * @group contacts-unit
     */
    public function test_can_add_contact_with_name_and_phone_number()
    {
        $contact = Contact::factory()
            ->has(Phonenumber::factory()->count(1))
            ->create();
        //dd($contact);
        $this->assertNotNull($contact);
        $this->assertGreaterThan(0, $contact->id);
        $this->assertIsString($contact->firstname);
        $this->assertIsString($contact->lastname);

        $this->assertNotNull($contact->phonenumbers);
        $this->assertGreaterThan(0, $contact->phonenumbers->count());
    }

    protected function setUp() : void
    {
        parent::setUp();

        $contact = Contact::factory()
            ->has(Phonenumber::factory()->count(1))
            ->create();
    }

    protected function tearDown() : void {
        parent::tearDown();
    }
}
