<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOldSubscriptionsLog extends Model
{
    protected $table = 'tbl_user_old_subscriptions_log';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        // public function package()
        // {
        //     return $this->belongsTo(Package::class, 'package_id');
        // }

    //subscription_id paypal_id invoice_number
}
