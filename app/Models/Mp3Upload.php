<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp3Upload extends Model
{
    protected $table = 'tbl_mp3_upload';
    protected $guarded = [];

// public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_upload_id');
    // }
}
