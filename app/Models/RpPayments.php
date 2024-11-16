<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RpPayments extends Model
{
    protected $table = 'tbl_rp_payments';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
