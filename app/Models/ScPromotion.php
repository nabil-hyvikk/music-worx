<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScPromotion extends Model
{
    protected $table = 'tbl_sc_promotion';
    protected $guarded = [];

    //     public function promo()
//     {
//         return $this->belongsTo(Promo::class, 'promo_id');
//     }


    //     public function track()
//     {
//         return $this->belongsTo(Track::class, 'track_id');
//     }


    //     public function originalRelease()
//     {
//         return $this->belongsTo(Release::class, 'org_release_id', 'id');
//     }

}
