<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeknewsPromoSelection extends Model
{
    protected $table = 'tbl_weeknews_promo_selection';
    protected $guarded = [];
    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id', 'id');
    }

}
