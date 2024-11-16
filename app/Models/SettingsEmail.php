<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsEmail extends Model
{
    protected $table = 'tbl_settings_email';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
