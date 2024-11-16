<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedTop10OfWeek extends Model
{
    protected $table = 'tbl_featured_top10_of_week';
    protected $guarded = [];

    // public function chart()
    // {
    //     return $this->belongsTo(Chart::class, 'chart_id');
    // }
}
