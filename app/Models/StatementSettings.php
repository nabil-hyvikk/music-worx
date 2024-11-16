<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatementSettings extends Model
{
    protected $table = 'tbl_statement_settings';
    protected $guarded = [];
    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id');
    // }

}
