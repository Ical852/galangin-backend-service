<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function campaign_comments()
    {
        return $this->hasMany(CampaignComments::class);
    }

    public function campaign_donation()
    {
        return $this->hasMany(CampaignDonation::class);
    }

    public function campaign_news()
    {
        return $this->hasMany(CampaignNews::class);
    }

    public function collab_campaign()
    {
        return $this->hasMany(CollabCampaign::class);
    }

    public function getImageAttribute()
    {
        return url('') . Storage::url($this->attributes['image']);
    }
}
