<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class PerformanceReview extends Model
{
    protected $collection = "crm_performance_reviews";
    protected $fillable = ['employeeId','branchId','empaloyeeIdCode','departmentId','managerId','dateOfReview','reviewPeriodFrom','reviewPeriodTo','reviewerName','jobKnowledge','qualityOfWork','productivity','teamworkCollaboration','problemSolvingSkills','adaptability','dependability','overallRating','managerFeedbackForEmployee','hrId','department'];

    public function employee(){
        return $this->belongsTo(Team::class,'employeeId','_id');
    }
    public function manager(){
        return $this->belongsTo(Team::class,'managerId','_id');
    }
}
