<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountMembership extends Model
{
    protected $table = 'tbl_discount_membership';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
