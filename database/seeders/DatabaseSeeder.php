<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignComments;
use App\Models\CampaignDonation;
use App\Models\CampaignNews;
use App\Models\CampaignNewsComments;
use App\Models\CampaignNewsCommentsReply;
use App\Models\Category;
use App\Models\CollabCampaign;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Category::factory(5)->create();
        Campaign::factory(15)->create();
        Notification::factory(30)->create();
        CampaignComments::factory(30)->create();
        CampaignDonation::factory(30)->create();
        CampaignNews::factory(30)->create();
        CampaignNewsComments::factory(60)->create();
        Reply::factory(60)->create();
        CampaignNewsCommentsReply::factory(60)->create();
        CollabCampaign::factory(30)->create();
    }
}
