<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelEmailUnavailable extends Model
{
    protected $table = 'tbl_label_email_unavailable';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
