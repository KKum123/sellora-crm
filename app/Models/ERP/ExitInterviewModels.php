<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class ExitInterviewModels extends Model
{
    protected $collection = "crm_exit_employees";
    protected $fillable = ['hrId','employeeId','emialId','departmentId','JobTittle','designationId','DateOfJoining','LastWorkingDay','considerRejoiningOurCompany','ReasonOfLeaving','FeedbackForCompany','ReportingManagerFeedback'];

    public function employee(){
        return $this->belongsTo(Team::class,'employeeId','_id');
    }

    public function departments(){
        return $this->belongsTo(Department::class,'departmentId','_id');
    }
    public function designations(){
        return $this->belongsTo(Designation::class,'designationId','_id');
    }
    
}

