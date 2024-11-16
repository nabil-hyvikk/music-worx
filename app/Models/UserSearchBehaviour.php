<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSearchBehaviour extends Model
{
    protected $table = 'tbl_user_search_behaviour';
    protected $guarded = [];

    // public function artistRelation()
    // {
    //     return $this->belongsTo(Artist::class, 'artist');
    // }

    // // If you have a Track model
    // public function trackRelation()
    // {
    //     return $this->belongsTo(Track::class, 'track');
    // }

    // // If you have a Release model
    // public function releaseRelation()
    // {
    //     return $this->belongsTo(Release::class, 'release');
    // }
}
