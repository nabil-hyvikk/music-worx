<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGenres extends Model
{
    protected $table = 'tbl_user_genres';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
