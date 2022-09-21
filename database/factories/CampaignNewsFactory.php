<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignNewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'campaign_id' => mt_rand(1,15),
            'user_id' => mt_rand(1,10),
            'message' => $this->faker->sentence(mt_rand(3,5)),
            'total_likes' => 0
        ];
    }
}
