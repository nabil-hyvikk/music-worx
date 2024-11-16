<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminReviewerActivity extends Model
{
    protected $table = 'tbl_admin_reviewer_activity';
    protected $guarded = [];

    // // Define relationship with User model (assuming user_id refers to a User table)
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    // // If `release_id` refers to a specific model, define that relationship
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id'); // Adjust 'Release::class' as needed
    // }

    // // If `track_id` refers to a specific model, define that relationship
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id'); // Adjust 'Track::class' as needed
    // }
}
