<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamboxLog extends Model
{
    protected $table = 'tbl_streambox_log';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }

    public function streambox()
    {
        return $this->belongsTo(Streambox::class, 'streambox_id');
    }
}
