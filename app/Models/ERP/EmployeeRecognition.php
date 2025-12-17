<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class EmployeeRecognition extends Model
{
    protected $collection = "crm_employee_recognitions";
    protected $fillable = ['employeeId','recognitionCategory','hrId','branchId'];

    public function employee(){
        return $this->belongsTo(Team::class, 'employeeId', '_id');
    }
}
