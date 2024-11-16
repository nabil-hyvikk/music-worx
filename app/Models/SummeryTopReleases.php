<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummeryTopReleases extends Model
{
    protected $table = 'summery_top_releases';
    protected $guarded = [];

    //  // Define relationship with Release model (assuming release_id refers to a Release table)
    //  public function release()
    //  {
    //      return $this->belongsTo(Release::class, 'release_id', 'id');
    //  }

}
