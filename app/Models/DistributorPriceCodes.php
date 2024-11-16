<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorPriceCodes extends Model
{
    protected $table = 'tbl_distributor_price_codes';
    protected $guarded = [];

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id');
    // }
}
