<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorTracks extends Model
{
    protected $table = 'tbl_visitor_tracks';
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
