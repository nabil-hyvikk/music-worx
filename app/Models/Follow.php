<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'tbl_follow';
    protected $guarded = [];

    public function track()
    {
        return $this->belongsTo(Mp3Mix::class, 'following', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followingUser()
    {
        return $this->belongsTo(User::class, 'following', 'id');
    }

    public function release()
    {
        return $this->belongsTo(Release::class, 'release_id');
    }

}
