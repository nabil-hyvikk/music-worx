<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialDownload extends Model
{
    protected $table = 'tbl_social_download';
    protected $guarded = [];
    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'admin_id', 'id');
    // }

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id');
    // }
}
