<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripePaymentIntents extends Model
{
    protected $table = 'tbl_stripe_payment_intents';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    //intent_id

}
