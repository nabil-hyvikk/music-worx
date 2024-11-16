<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamboxItems extends Model
{
    protected $table = 'tbl_streambox_items';
    protected $guarded = [];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function streambox()
    {
        return $this->belongsTo(Streambox::class, 'streambox_id', 'id');
    }

    public function track()
    {
        return $this->belongsTo(Mp3Mix::class, 'track_id', 'id');
    }
}
