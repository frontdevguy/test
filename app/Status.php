<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['status_text','status_video_url'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
