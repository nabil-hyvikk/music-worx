<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'email_list';
    protected $guarded = ['id'];
    public $timestamps = false;
}
