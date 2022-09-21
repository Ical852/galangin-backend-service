<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignNewsCommentsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_news_comments_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id');
            $table->foreignId('user_id');
            $table->string('reply');
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
        Schema::dropIfExists('campaign_news_comments_replies');
    }
}
