<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReleaseRemovalList extends Model
{
    protected $table = 'tbl_release_removal_list';
    protected $guarded = [];

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id');
    // }
}
