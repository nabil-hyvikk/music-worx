<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamsManagement extends Model
{
    protected $table = 'tbl_streams_management';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
