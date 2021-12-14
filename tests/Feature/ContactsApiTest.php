<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Contact;
use App\Models\Phonenumber;

class ContactsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_add_new_contact_name_with_phone_number()
    {
        $response = $this->get('/api/contacts');
        $response->assertStatus(200);
    }

    /**
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_delete_contact()
    {
        $response = $this->delete('/api/contacts');
        $response->assertStatus(200);
    }

    /**
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_lookup_contact_by_name()
    {
        $response = $this->get('/api/contacts?by=name&q=');
        $response->assertStatus(200);
    }

    /**
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_lookup_contact_by_phone_number()
    {
        $response = $this->get('/api/contacts?by=number&q=');
        $response = $this->get('/api/contacts');
        $response->assertStatus(200);
    }

    // -------------

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
