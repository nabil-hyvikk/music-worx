<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSelectedNews extends Model
{
    protected $table = 'tbl_newsletter_selected_news';
    protected $guarded = [];

    // public function news()
    // {
    //     return $this->belongsTo(News::class, 'news_id', 'id');
    // }

    // public function newsletter()
    // {
    //     return $this->belongsTo(Newsletter::class, 'newsletter_id', 'id');
    // }

}
