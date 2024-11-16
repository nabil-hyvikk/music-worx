<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistNewtracksChecked extends Model
{
    protected $table = 'tbl_artist_newtracks_checked';
    protected $guarded = [];

    // // Define relationship with User model (assuming user_id refers to a User table)
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id'); // Adjust as necessary
    // }

    //public function artist()
    // {
    //     return $this->belongsTo(Artist::class, 'artist_id', 'id'); // Adjust as necessary
    // }
}
