<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Phonenumber;

class PhonenumberFactory extends Factory
{
    public function definition()
    {
        $isCountrySelected = $this->faker->boolean(70);
        $country = $isCountrySelected
            ? $this->faker->randomElement( array_keys(Phonenumber::$countries) )
            : null;

        $data = [];

        if ( $country ) {
            $mask = Phonenumber::$countries[$country]['mask'];
            $countryCode = Phonenumber::$countries[$country]['country_code'];
            $len = substr_count( $mask, '#'); // digits only, does include country code
            $ccLen = strlen((string)$countryCode); // assumes no country calling codes start with '0'
            $data['phonenumber'] = $countryCode.$this->randomNumber($len-$ccLen);
            $data['country'] = $country;
        } else {
            $data['phonenumber'] = $this->faker->e164PhoneNumber;
        }

        return $data;
    }
    
    function randomNumber($length) {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

}
