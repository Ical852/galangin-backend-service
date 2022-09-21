<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignCommentsFactory extends Factory
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
            'comment' => $this->faker->sentence(mt_rand(2,3)),
            'total_likes' => 0
        ];
    }
}
