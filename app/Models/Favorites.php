<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'tbl_favorites';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function favoritingUser()
    // {
    //     return $this->belongsTo(User::class, 'favoriting_user_id');
    // }
}
