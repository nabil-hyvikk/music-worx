<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminReviewerSliderFeat extends Model
{
    protected $table = 'tbl_admin_reviewer_slider_feat';
    protected $guarded = [];

    // public function adminUser()
    // {
    //     return $this->belongsTo(User::class, 'admin_user_id', 'id');
    // }

    // // If release_id refers to a specific model, define that relationship
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }
}
