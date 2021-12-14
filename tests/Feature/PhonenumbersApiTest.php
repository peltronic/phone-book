<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Phonenumber;

class PhonenumbersApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group api
     * @group persons
     * @group persons-api
     */
    public function test_should_return_list_of_phone_numbers()
    {
        $response = $this->get('/api/phonenumbers');
        //$content = json_decode($response->content());
        //dd($content);

        $response->assertStatus(200);
    }

    protected function setUp() : void
    {
        parent::setUp();

        $contact = User::factory()
            ->has(Phonenumber::factory()->count(1))
            ->create();
    }

    protected function tearDown() : void {
        parent::tearDown();
    }
}
