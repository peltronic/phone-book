<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        // \App\Models\User::factory(10)->create();
        Contact::factory(3)
            ->has(Phonenumber::factory()->count(1))
            ->create();

        Contact::factory(2)
            ->has(Phonenumber::factory()->count(2))
            ->create();
    }
}
