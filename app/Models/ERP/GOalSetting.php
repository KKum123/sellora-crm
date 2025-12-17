<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class GOalSetting extends Model
{
    protected $collection = "crm_goal_settings";
    protected $fillable = ['employeeId','branchId','employeeIdCode','department','departmentId','managerId','dateOfJoin','dateAssigned','goalReviewDate','goalTitle','goalType','revenueTarget','milestoneStatus','goalPriority','frequencyOfUpdates','completionDate','managerFeedback','hrId'];

    public function employee(){
        return $this->belongsTo(Team::class,'employeeId','_id');
    }
    public function manager(){
        return $this->belongsTo(Team::class, 'managerId','_id');
    }
}
