<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualSlidersMaster extends Model
{
    protected $table = 'tbl_manual_sliders_master';
    protected $guarded = [];
    // public function manualSliderReleases()
    // {
    //     return $this->hasMany(ManualSliderRelease::class, 'release_id', 'id'); // Adjust 'ManualSliderRelease::class' if your model name is different
    // }
}
