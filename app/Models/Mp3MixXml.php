<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp3MixXml extends Model
{
    protected $table = 'tbl_mp3_mix_xml';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
     // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_upload_id', 'id');
    // }

}
