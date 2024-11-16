<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualSliderDjcharts extends Model
{
    protected $table = 'tbl_manual_slider_djcharts';
    protected $guarded = [];

    // public function chart()
    // {
    //     return $this->belongsTo(Chart::class, 'chart_id', 'id'); // Adjust 'Chart::class' if your model name is different
    // }
}
