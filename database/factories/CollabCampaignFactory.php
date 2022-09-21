<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CollabCampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'campaign_id' => mt_rand(1,30),
            'user_id' => mt_rand(1,10)
        ];
    }
}
