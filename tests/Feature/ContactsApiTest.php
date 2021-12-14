<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

use Tests\TestCase;

use App\Models\User;
use App\Models\Contact;
use App\Models\Phonenumber;

class ContactsApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @group here1213
     * @group regression
     * @group api
     * @group contacts
     */
    public function test_should_list_all_contacts()
    {
        $response = $this->ajaxJSON('GET', route('contacts.index'));
        $response->assertStatus(200);
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
     * @group regression
     * @group api
     * @group contacts
     */
    public function test_should_add_new_contact_name_with_phone_number()
    {
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
     * @group regression
     * @group api
     * @group contacts
     */
    public function test_should_delete_contact()
    {
        // Retrieve a contact to delete
        $contactToDelete = Contact::has('phonenumbers')->first();
        $this->assertGreaterThan(0, $contactToDelete->phonenumbers->count());

        $response = $this->ajaxJSON('DELETE', route('contacts.destroy', $contactToDelete->id) );
        $response->assertStatus(200);

        $shouldBeNull = Contact::find($contactToDelete->id);
        $this->assertNull($shouldBeNull);

        $shouldBeZero = Phonenumber::where('contact_id', $contactToDelete->id)->count();
        $this->assertEquals(0, $shouldBeZero);

        // [ ] test that [contacts] record deleted
        // [ ] test that related [phonenumbers] records deleted
    }

    /**
     * @group regression
     * @group api
     * @group contacts
     */
    public function test_should_lookup_contact_by_name()
    {
        $contactToQuery = Contact::has('phonenumbers')->first();

        // --- By first name ---

        $qStr = Str::of($contactToQuery->firstname)->substr(0, 2);
        $params = [ 'by' => 'name', 'q' => $qStr ];
        $response = $this->ajaxJSON('GET', route('contacts.index', $params));
        $response->assertStatus(200);

        // --- By last name ---

        $qStr = Str::of($contactToQuery->lastname)->substr(0, 2);
        $params = [ 'by' => 'name', 'q' => $qStr ];
        $response = $this->ajaxJSON('GET', route('contacts.index', $params));
        $response->assertStatus(200);
    }

    /**
     * @group regression
     * @group api
     * @group contacts
     */
    public function test_should_lookup_contact_by_phone_number()
    {
        $contactToQuery = Contact::has('phonenumbers')->first();
        $this->assertGreaterThan(0, $contactToQuery->phonenumbers->count());

        // --- From first digit ---

        $qStr = Str::of($contactToQuery->phonenumbers[0]->phonenumber)->substr(0, 2);
        $params = [ 'by' => 'number', 'q' => $qStr ];
        $response = $this->ajaxJSON('GET', route('contacts.index', $params));
        $response->assertStatus(200);

        // --- From mid-digit ---

        $qStr = Str::of($contactToQuery->phonenumbers[0]->phonenumber)->substr(3, 3);
        $params = [ 'by' => 'number', 'q' => $qStr ];
        $response = $this->ajaxJSON('GET', route('contacts.index', $params));
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
