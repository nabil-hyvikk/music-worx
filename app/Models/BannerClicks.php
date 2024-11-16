<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerClicks extends Model
{
    protected $table = 'tbl_banner_clicks';
    protected $guarded = [];

    // // If release_id refers to a specific model, define that relationship
    // public function banner()
    // {
    //     return $this->belongsTo(Banners::class, 'banner_id', 'id');
    // }

    // // If release_id refers to a specific model, define that relationship
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }
}
