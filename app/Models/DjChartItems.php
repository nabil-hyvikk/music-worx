<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DjChartItems extends Model
{
    protected $table = 'tbl_dj_chart_items';
    protected $guarded = [];

    // public function chart()
    // {
    //     return $this->belongsTo(Chart::class, 'chart_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id'); // Adjust the foreign key relationship as necessary
    // }

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }
}
