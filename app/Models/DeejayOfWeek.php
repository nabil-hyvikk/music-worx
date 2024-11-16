<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeejayOfWeek extends Model
{
    protected $table = 'tbl_deejay_of_week';
    protected $guarded = [];

    // public function deejay()
    // {
    //     return $this->belongsTo(Deejay::class, 'deejay_id');
    // }
}
