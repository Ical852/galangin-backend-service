<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignNewsCommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'campaign_news_id' => mt_rand(1,30),
            'user_id' => mt_rand(1,10),
            'comment' => $this->faker->sentence(mt_rand(1,3)),
            'total_likes' => 0
        ];
    }
}
