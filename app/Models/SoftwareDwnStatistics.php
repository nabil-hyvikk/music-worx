<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareDwnStatistics extends Model
{
    protected $table = 'tbl_software_dwn_statistics';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
