<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YtPromotion extends Model
{
    protected $table = 'tbl_yt_promotion';
    protected $guarded = [];
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id', 'id');
    }
    // 'org_release_id',
//         'playlist_id',
//         'video_id',
//
}
