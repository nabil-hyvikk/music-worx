<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCouponManagement extends Model
{
    protected $table = 'tbl_user_coupon_management';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function coupon()
    // {
    //     return $this->belongsTo(Coupon::class, 'coupon_id');
    // }
}
