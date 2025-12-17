<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class Leave extends Model
{
    protected $collection = "crm_leave";
    protected $fillable = ['hrId','employeeId','fromDate','toDate','remarks','leaveStatus','totalLeave','applyDate'];
    
    public function employee(){
        return $this->belongsTo(Team::class, 'employeeId','_id');
    }
}
