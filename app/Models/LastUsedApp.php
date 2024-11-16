<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastUsedApp extends Model
{
    protected $table = 'tbl_last_used_app';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
