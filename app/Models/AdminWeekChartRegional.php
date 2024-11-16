<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminWeekChartRegional extends Model
{
    protected $table = 'tbl_admin_week_chart_regional';
    protected $guarded = [];

    // // Define relationship with User model (assuming user_id refers to a User table)
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id'); // Adjust as necessary
    // }

    // // If track_id refers to a specific model, define that relationship
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id'); // Adjust as necessary
    // }

    // // If release_id refers to a specific model, define that relationship
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id'); // Adjust as necessary
    // }
}
