<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimRequest extends Model
{
    protected $table = 'tbl_claim_request';
    protected $guarded = [];

    // Relationships
    // public function artist()
    // {
    //     return $this->belongsTo(Artist::class, 'artist_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'request_from');
    // }
}
