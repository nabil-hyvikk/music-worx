<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackArtistsTmp extends Model
{
    protected $table = 'tbl_track_artists_tmp';
    protected $guarded = [];

    public function track()
    {
        return $this->belongsTo(Mp3Mix::class, 'track_id', 'id');
    }

    public function artist()
    {
        return $this->belongsTo(TrackArtists::class, 'artist_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'artist_id','id');
    }

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id');
    }
}
