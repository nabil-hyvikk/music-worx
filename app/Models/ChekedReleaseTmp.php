<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChekedReleaseTmp extends Model
{
    protected $table = 'tbl_cheked_release_tmp';
    protected $guarded = [];

    // // Relationships can be added here, for example:
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function release()
    // {
    //     // Assuming there's a Release model with a matching release_id
    //     return $this->belongsTo(Release::class, 'release_id');
    // }
}
