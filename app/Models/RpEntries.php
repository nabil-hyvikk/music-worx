<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RpEntries extends Model
{
    protected $table = 'tbl_rp_entries';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }


    // public function credit()
    // {
    //     return $this->belongsTo(Credit::class, 'credit_id');
    // }


    // public function promotion()
    // {
    //     return $this->belongsTo(Promotion::class, 'promo_id');
    // }


}
