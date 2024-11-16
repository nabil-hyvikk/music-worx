<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlanServices extends Model
{
    protected $table = 'tbl_membership_plan_services';
    protected $guarded = [];
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
