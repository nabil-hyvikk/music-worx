<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorSettings extends Model
{
    protected $table = 'tbl_distributor_settings';
    protected $guarded = [];

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'dist_id');
    // }
}
