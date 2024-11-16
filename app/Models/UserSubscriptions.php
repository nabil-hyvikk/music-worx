<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
    protected $table = 'tbl_user_subscriptions';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function package()
    // {
    //     return $this->belongsTo(Package::class, 'package_id');
    // }

    //subscription_id invoice_number paypal_id
}
