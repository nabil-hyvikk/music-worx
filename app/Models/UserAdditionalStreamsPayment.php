<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdditionalStreamsPayment extends Model
{
    protected $table = 'tbl_user_additional_streams_payment';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
    // public function package()
    // {
    //     return $this->belongsTo(Package::class, 'package_id', 'id');
    // }

    //paypal_id order_id invoice_number
}
