<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignNews extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign_news_comments()
    {
        return $this->hasMany(CampaignNewsComments::class);
    }
}
