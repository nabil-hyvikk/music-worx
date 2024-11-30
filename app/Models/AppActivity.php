<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class AppActivity extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'app_activity';
    protected $guarded = [];
    public $timestamps = false;
}
