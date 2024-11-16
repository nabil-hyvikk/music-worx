<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WronglyLiveReleases extends Model
{
    protected $table = 'wrongly_live_releases';
    protected $guarded = [];

    // 'user_id',
    //     'distributor_id',
    //     'release_id',
}
