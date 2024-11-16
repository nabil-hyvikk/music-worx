<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDicountOnPurchase extends Model
{
    protected $table = 'tbl_user_dicount_on_purchase';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
