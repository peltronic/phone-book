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

        $data = [];

        if ( $country ) {
            $data['country'] = $country;
            $len = substr_count( Phonenumber::$countries[$country]['mask'], '#'); // digits only, does not include country code
            //dd($len);
            //$data['phonenumber'] = $this->faker->randomNumber($len);
            $data['phonenumber'] = $this->randomNumber($len);
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
