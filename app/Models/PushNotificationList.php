<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotificationList extends Model
{
    protected $table = 'tbl_push_notification_list';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class, 'nl_id');
    }
}
