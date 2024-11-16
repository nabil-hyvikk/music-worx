<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomSectionOfTheWeek extends Model
{
    protected $table = 'tbl_custom_section_of_the_week';
    protected $guarded = [];

    // public function customSection()
    // {
    //     return $this->belongsTo(CustomSection::class, 'custom_section_id');
    // }
}
