<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCommentsRatings extends Model
{
    protected $table = 'tbl_user_comments_ratings';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }

}
