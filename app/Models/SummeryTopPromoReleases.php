<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummeryTopPromoReleases extends Model
{
    protected $table = 'summery_top_promo_releases';
    protected $guarded = [];

    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }
}
