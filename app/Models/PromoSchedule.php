<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoSchedule extends Model
{
    protected $table = 'tbl_promo_schedule';
    protected $guarded = [];
    // public function promo()
    // {
    //     return $this->belongsTo(Promo::class, 'promo_id');
    // }
}
