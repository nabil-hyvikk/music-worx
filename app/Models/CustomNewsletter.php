<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomNewsletter extends Model
{
    protected $table = 'tbl_custom_newsletter';

    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
