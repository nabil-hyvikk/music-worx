<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionsHistory extends Model
{
    protected $table = 'tbl_user_subscriptions_history';
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
