<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignNewsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_news_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_news_id');
            $table->foreignId('user_id');
            $table->string('comment');
            $table->integer('total_likes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_news_comments');
    }
}
