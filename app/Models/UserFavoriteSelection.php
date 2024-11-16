<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteSelection extends Model
{
    protected $table = 'tbl_user_favorite_selection';
    protected $guarded = [];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // // Relationship to the Track model (assumed model name)
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }

}
