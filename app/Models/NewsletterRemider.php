<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterRemider extends Model
{
    protected $table = 'tbl_newsletter_remider';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
