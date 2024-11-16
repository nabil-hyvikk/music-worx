<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelOfWeek extends Model
{
    protected $table = 'tbl_label_of_week';

    protected $guarded = [];
    // public function label()
    // {
    //     return $this->belongsTo(Label::class, 'label_id');
    // }
}
