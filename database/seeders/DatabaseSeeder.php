<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Contact;
use App\Models\Phonenumber;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Phonenumber::truncate();
        Contact::truncate();

        // \App\Models\User::factory(10)->create();
        Contact::factory(7)
            ->has(Phonenumber::factory()->count(1))
            ->create();

        Contact::factory(3)
            ->has(Phonenumber::factory()->count(2))
            ->create();

        $this->adjustTimestamps();
    }

    // Manually back-date timestamps to make them look more realistic
    protected function adjustTimestamps()
    {
        $faker = Factory::create();
        $contacts = Contact::get();

        $contacts->each( function($c) use(&$faker) {
            $ts = $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now');
            $c->created_at = $ts;
            $c->updated_at = $ts;
            $c->save();
            $c->phonenumbers->each( function($pn) use($ts) {
                $pn->created_at = $ts;
                $pn->updated_at = $ts;
                $pn->save();
            });
        });
    }
}
