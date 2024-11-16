<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistRequest extends Model
{
    protected $table = 'tbl_artist_request';
    protected $guarded = [];

    //public function artist()
    // {
    //     return $this->belongsTo(Artist::class, 'artist_id', 'id'); // Adjust as necessary
    // }
}
