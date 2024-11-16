<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentPromos extends Model
{
    protected $table = 'tbl_sent_promos';
    protected $guarded = [];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }


    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id'); // Assuming 'id' is the primary key of releases
    // }


    // public function promo()
    // {
    //     return $this->belongsTo(Promo::class, 'promo_id', 'id'); // Assuming 'id' is the primary key of promos
    // }

}
