<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignNewsCommentsReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment_id' => mt_rand(1,60),
            'user_id' => mt_rand(1,10),
            'reply' => $this->faker->sentence(mt_rand(1,3)),
            'total_likes' => 0
        ];
    }
}
