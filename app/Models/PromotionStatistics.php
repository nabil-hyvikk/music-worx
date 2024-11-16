<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionStatistics extends Model
{
    protected $table = 'tbl_promotion_statistics';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id');
    // }

}
