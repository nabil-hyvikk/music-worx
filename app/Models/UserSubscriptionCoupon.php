<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionCoupon extends Model
{
    protected $table = 'tbl_user_subscription_coupon';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function coupon()
    // {
    //     return $this->belongsTo(Coupon::class, 'coupon_id');
    // }

    // public function plan()
    // {
    //     return $this->belongsTo(Plan::class, 'plan_id');
    // }
}
