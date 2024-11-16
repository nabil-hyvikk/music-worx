<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedBasket extends Model
{
    protected $table = 'tbl_ordered_basket';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function items()
    {
        return $this->hasMany(OrderedBasketItems::class, 'ordered_basket_id');
    }

    // public function applyDiscount($percentage)
    // {
    //     if ($this->cart_total && $percentage > 0) {
    //         return $this->cart_total - ($this->cart_total * ($percentage / 100));
    //     }

    //     return $this->cart_total;
    // }
    // public function isCreditCardPayment()
    // {
    //     return strtolower($this->payment_method) === 'credit_card';
    // }
    // public function calculateVAT($vatRate)
    // {
    //     return $this->cart_subtotal * ($vatRate / 100);
    // }

}
