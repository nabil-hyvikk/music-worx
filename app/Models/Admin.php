<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $guarded = [];

    public function mobile_token()
    {
        return $this->hasOne(UsersMobileToken::class, 'user_id');
    }
}
