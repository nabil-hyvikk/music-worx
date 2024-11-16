<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotifyArtists extends Model
{
    protected $table = 'tbl_spotify_artists';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //spotify_id
}
