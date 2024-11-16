<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearInReview extends Model
{
    protected $table = 'year_in_review';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
