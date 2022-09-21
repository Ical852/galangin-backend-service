<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignComments extends Model
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

    public function reply()
    {
        return $this->hasMany(Reply::class, 'comment_id', 'id');
    }
}
