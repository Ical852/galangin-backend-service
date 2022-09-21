<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->hasMany(Campaign::class);
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

    public function campaign_news_comments()
    {
        return $this->hasMany(CampaignNewsComments::class);
    }

    public function collab_campaign()
    {
        return $this->hasMany(CollabCampaign::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function getImageAttribute()
    {
        return url('') . Storage::url($this->attributes['image']);
    }
}
