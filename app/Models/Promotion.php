<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'tbl_promotion';
    protected $guarded = [];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id');
    // }

    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class, 'invoice_id');
    // }
}
