<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddDownloadRequest extends Model
{
    protected $table = 'tbl_add_download_request';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
