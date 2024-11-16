<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateNotifications extends Model
{
    protected $table = 'tbl_update_notifications';
    protected $guarded = [];

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    // }
}
