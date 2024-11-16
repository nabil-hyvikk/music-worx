<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminfeedbacks extends Model
{
    protected $table = 'tbl_adminfeedbacks';

    protected $guarded = [];

    //  // Define relationship with User model (assuming userid refers to a User table)
    //  public function user()
    //  {
    //      return $this->belongsTo(User::class, 'userid', 'id'); // Adjust as necessary
    //  }
}
