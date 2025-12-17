<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class LeaveList extends Model
{
    protected $collection = "crm_leaveList";
    protected $fillable = ['leaveId','hrId','employeeId','leaveDate','remarks','leaveStatus'];
}
