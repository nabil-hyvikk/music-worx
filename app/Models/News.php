<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'tbl_news';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'added_by');
    // }

}
