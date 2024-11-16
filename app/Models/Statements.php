<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statements extends Model
{
    protected $table = 'tbl_statements';
    protected $guarded = [];

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id');
    // }
}
