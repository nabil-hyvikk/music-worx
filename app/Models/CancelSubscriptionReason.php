<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelSubscriptionReason extends Model
{
    protected $table = 'tbl_cancel_subscription_reason';
    protected $guarded = [];

    //user_id subscription_id plan_id
}
