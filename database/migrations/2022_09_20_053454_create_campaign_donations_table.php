<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id');
            $table->foreignId('user_id');
            $table->string('order_id');
            $table->integer('donation_amount');
            $table->string('message');
            $table->string('payment_url');
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
        Schema::dropIfExists('campaign_donations');
    }
}
