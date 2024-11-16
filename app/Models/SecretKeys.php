<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SecretKeys extends Model
{
    use HasApiTokens;
    protected $table = 'secret_keys';
    protected $guarded = [];
}
