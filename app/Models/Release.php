<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $table = 'tbl_release';
    protected $guarded = [];

    public function artists()
    {
        return $this->belongsToMany(User::class, 'tbl_track_artists', 'release_id', 'release_id');
    }

    public function label()
    {
        return $this->belongsTo(User::class, 'label', 'id');
    }

    public function trackArtists()
    {
        return $this->hasMany(TrackArtists::class, 'release_id', 'release_id');
    }

    // public function trackArtists()
    // {
    //     return $this->hasMany(TrackArtists::class, 'release_id', 'release_id');
    // }

    public function tracks()
    {
        return $this->hasMany(Mp3Mix::class, 'release_id', 'release_id');
    }

    public function statistics()
    {
        return $this->hasMany(Mp3Statistics::class, 'release_id', 'release_id');
    }


    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id'); // Assuming you have a User model
    // }

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id'); // Assuming you have a Distributor model
    // }

    // public function genres()
    // {
    //     return $this->belongsToMany(Genre::class, 'release_genre', 'release_id', 'genre_id'); // Assuming a pivot table for genres
    // }

    //release_id

}
