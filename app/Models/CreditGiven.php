<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditGiven extends Model
{
    protected $table = 'tbl_credit_given';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
