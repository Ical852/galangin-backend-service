<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignNewsComments extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function campaign_news()
    {
        return $this->belongsTo(CampaignNews::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign_news_comments_reply()
    {
        return $this->hasMany(Reply::class, 'comment_id', 'id');
    }
}
