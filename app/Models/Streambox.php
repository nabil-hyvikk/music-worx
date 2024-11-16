<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streambox extends Model
{
    protected $table = 'tbl_streambox';
    protected $guarded = [];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items()
    {
        return $this->hasMany(StreamboxItems::class, 'streambox_id', 'id');
    }

    public function tracks() {
        return $this->hasManyThrough(Mp3Mix::class, StreamboxItems::class, 'streambox_id', 'id', 'id', 'track_id');
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'following', 'id')->where('type', 'playlist');
    }
    public function followersCount()
    {
        return $this->hasMany(Follow::class, 'following', 'id')
            ->where('type', 'playlist');
    }
}
