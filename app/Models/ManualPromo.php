<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualPromo extends Model
{
    protected $table = 'tbl_manual_promo';
    protected $guarded = [];
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'added_by', 'id');
    // }
}
