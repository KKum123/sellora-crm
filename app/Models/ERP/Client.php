<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class Client extends Model
{
    protected $collection = "crm_clients";
    protected $fillable = ["countryName",'branchId','requestId','requestName','phoneNo','emailId','city','serviceCategory','requestLocation','requestSellCountry','assignOperationManager','noteFromRequest','jobTitle','leadId','moveByTeamId','moveByBranchId','moveByAdminId','status','assignOperationId','comment','assingByBranchId','assingByAdminId','assignByTeamId','createdByAdminId','createdByBranchId','createdByTeamId','assignAdminByOperationManager','countryCode','assignToOpsManagerId','moveFromBranchId','moveDate'];
    //assignToOpsManagerId assign client by admin or branch 
    protected $casts = [
        'moveDate' => 'datetime',
    ];
    
    public function salseData(){
        return $this->belongsTo(Team::class, 'moveByTeamId', '_id'); 
    }
    public function leadFollowupData(){
        return $this->hasMany(FollowUpLead::class, 'leadId', 'leadId');
    }
    public function assigntask(){
        return $this->hasMany(AssignTask::class, 'clientId', '_id');
     }
     public function operationTeam(){
        return $this->belongsTo(Team::class, 'assignOperationId', '_id');
    }public function operationManagerTeam(){
        return $this->belongsTo(Team::class, 'assignToOpsManagerId', '_id');
    }
    public function tasks()
    {
        return $this->hasMany(AssignTask::class, 'clientId', '_id');
    }
    public function createdTeam(){
        return $this->belongsTo(Team::class, 'createdByTeamId', '_id');
    }
    public function branches(){
        return $this->belongsTo(Branch::class, 'branchId', '_id');
    }
}
