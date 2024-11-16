<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadioStation extends Model
{
    protected $table = 'tbl_radio_station';
    protected $guarded = [];
    // public function promotions()
    // {
    //     return $this->hasMany(Promotion::class, 'radio_station_id');
    // }
}
