<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersMobileToken extends Model
{
    protected $table = 'tbl_users_mobile_token';
    protected $guarded = [];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
