<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'tbl_membership';
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class, 'membership_id', 'id'); // Adjust 'User::class' if your model name is different
    }
}
