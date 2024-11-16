<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    protected $table = 'tbl_regions';
    protected $guarded = [];

    // public function radioStations()
    // {
    //     return $this->hasMany(RadioStation::class, 'region_id');
    // }

}
