<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'tbl_banners';
    protected $guarded = [];

    //public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    //promo_id release_id
}
