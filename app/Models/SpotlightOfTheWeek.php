<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotlightOfTheWeek extends Model
{
    protected $table = 'tbl_spotlight_of_the_week';
    protected $guarded = [];
    // public function spotlight()
    // {
    //     return $this->belongsTo(Spotlight::class, 'spotlight_id');
    // }
}
