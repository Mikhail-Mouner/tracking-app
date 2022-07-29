<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        User::inRandomOrder()->first()->id;
        return [
            'parent_id' => 1,
            'partner_id' => 2,
        ];
    }
}
