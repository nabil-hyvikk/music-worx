<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DjCharts extends Model
{
    protected $table = 'tbl_dj_charts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeLatestPublished($query)
    {
        return $query->where('is_published', 1)->where('is_featured', 0)->orderBy('published_at', 'DESC');
    }
}
