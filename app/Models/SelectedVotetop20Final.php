<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectedVotetop20Final extends Model
{
    protected $table = 'tbl_selected_votetop_20_final';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id', 'id');
    }

    //track_id


}
