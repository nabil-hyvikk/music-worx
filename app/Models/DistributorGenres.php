<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorGenres extends Model
{
    protected $table = 'tbl_distributor_genres';
    protected $guarded = [];

    //  public function distributor()
//  {
//      return $this->belongsTo(Distributor::class, 'dist_id');
//  }
}
