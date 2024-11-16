<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsAudio extends Model
{
    protected $table = 'tbl_settings_audio';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
