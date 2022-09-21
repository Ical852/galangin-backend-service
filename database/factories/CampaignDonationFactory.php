<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignDonationFactory extends Factory
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
            'order_id' => mt_rand(100, 1000),
            'donation_amount' => mt_rand(1000000, 10000000),
            'message' => $this->faker->sentence(mt_rand(1,2)),
            'payment_url' => Str::random(10)
        ];
    }
}
