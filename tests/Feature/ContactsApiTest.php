<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use App\Models\User;
use App\Models\Contact;
use App\Models\Phonenumber;

class ContactsApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @group here1213
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_list_all_contacts()
    {
        $response = $this->get('/api/contacts');
        $content = json_decode($response->content());
        //dd($content);

        $this->assertIsArray($content->data);
        $this->assertGreaterThan(0, count($content->data));
        $this->assertNotNull($content->data[0]);
        $this->assertNotNull($content->data[0]->id);
        $this->assertIsString($content->data[0]->firstname);

        $this->assertNotNull($content->data[0]->phonenumbers);
        $this->assertGreaterThan(0, count($content->data[0]->phonenumbers));
        $this->assertNotNull($content->data[0]->phonenumbers[0]->phonenumber);
        $this->assertIsString($content->data[0]->phonenumbers[0]->phonenumber);

        $response->assertStatus(200);
    }

    /**
     * @group api
     * @group contacts
     * @group contacts-api
     */
    public function test_should_add_new_contact_name_with_phone_number()
    {
        $response = $this->post('/api/contacts');
        $payload = [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'phonenumber' => $this->faker->e164PhoneNumber,
        ];
        $response = $this->ajaxJSON('POST', route('contacts.store'), $payload);
        $content = json_decode($response->content());
        //dd($content);
        $response->assertStatus(201);

        $this->assertNotNull($content->data->id??null);
        $this->assertIsString($content->data->firstname);
        $this->assertIsString($content->data->lastname);
        $this->assertNotNull($content->data->phonenumbers);
        $this->assertGreaterThan(0, count($content->data->phonenumbers));
        $this->assertIsString($content->data->phonenumbers[0]->phonenumber);
        $this->assertEquals($content->data->id, $content->data->phonenumbers[0]->contact_id);
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

        $contact = Contact::factory(3)
            ->has(Phonenumber::factory()->count(1))
            ->create();

        $contact = Contact::factory(2)
            ->has(Phonenumber::factory()->count(2))
            ->create();
    }

    protected function tearDown() : void {
        parent::tearDown();
    }
}
