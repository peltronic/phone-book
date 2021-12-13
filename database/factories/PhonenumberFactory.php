<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhonenumberFactory extends Factory
{
    public function definition()
    {
        $phone = $this->faker->e164PhoneNumber;
        return [
            'phonenumber' => $phone,
        ];
    }

}
