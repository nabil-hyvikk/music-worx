<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadChart extends Model
{
    protected $table = 'tbl_download_chart';
    protected $guarded = [];
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id');
    // }
}
