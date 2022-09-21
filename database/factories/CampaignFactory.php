<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => mt_rand(1,10),
            'category_id' => mt_rand(1,5),
            'title' => $this->faker->title(),
            'image' => Str::random(10),
            'target' => mt_rand(10000000, 1500000000),
            'max_date' => strval($this->faker->date()),
            'desc' => $this->faker->sentence(mt_rand(3,5))
        ];
    }
}
