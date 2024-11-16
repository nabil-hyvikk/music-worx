<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteAlbum extends Model
{
    protected $table = 'tbl_user_favorite_album';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //favorite_id
}
