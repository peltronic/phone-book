<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Phonenumber;

class PhonenumberFactory extends Factory
{
    public function definition()
    {
        $isCountrySelected = $this->faker->boolean(50);
        $country = $isCountrySelected
            ? $this->faker->randomElement( array_keys(Phonenumber::$countries) )
            : null;

        $data = [
            'phonenumber' => $this->faker->e164PhoneNumber,
        ];

        if ( $country ) {
            $data['country'] = $country;
        }

        return $data;
    }

}
