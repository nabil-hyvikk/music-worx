<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummeryTopHype extends Model
{
    protected $table = 'summery_top_hype';
    protected $guarded = [];

    // // Define relationship with Track model (assuming track_id refers to a Track table)
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id');
    // }

    // // Define relationship with Release model (assuming release_id refers to a Release table)
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }

}
