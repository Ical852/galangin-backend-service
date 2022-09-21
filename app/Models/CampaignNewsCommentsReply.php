<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignNewsCommentsReply extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function campaign_news_comments()
    {
        return $this->belongsTo(CampaignNewsComments::class, 'comment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
