<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReleasePdf extends Model
{
    protected $table = 'tbl_release_pdf';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id', 'release_id');
    }
}
