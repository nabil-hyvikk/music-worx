<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeSubscriptionManagement extends Model
{
    protected $table = 'tbl_free_subscription_management';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function package()
    // {
    //     return $this->belongsTo(Package::class, 'package_id');
    // }

}
