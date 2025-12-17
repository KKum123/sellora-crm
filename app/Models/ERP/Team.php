<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Team extends Eloquent implements Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $collection = "crm_teams"; 

    protected $fillable = [
        "name", "email", "mobile", "employee_code", 
        "designation", "department", "password",
        "show_password", "status", "admin_id","branchId","createdByBranchId","createdByTeamId",
        "assignOperationByAdminId","assignOperationByTeamId","assignOperationByBranchId","operationManagerId",
        "employeeIdCode","dateOfBirth","gender","address","countryId","pinCode","reportsTo","joinDate","salary","profileImage","state"
    ];
    //createdByTeamId  means salse manager id
    //operationManagerId operation manager id


    public function getAuthIdentifierName()
    {
        return 'id'; 
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); 
    }

    public function getAuthPassword()
    {
        return $this->password; 
    }

    public function getRememberToken()
    {
        return $this->remember_token ?? null;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function department1()
    {
        return $this->belongsTo(Department::class, 'department', '_id');
    }
    public function designation1()
    {
        return $this->belongsTo(Designation::class, 'designation', '_id');
    }
    public function assignleads()
    {
        return $this->hasMany(Lead::class, 'assign_to_sales', '_id');
    }
    public function branches(){
        return $this->belongsTo(Branch::class, 'branchId', '_id');
    }
    public function exitEmployee(){
        return $this->belongsTo(ExitInterviewModels::class, '_id', 'employeeId');
    }
    public function salesManage(){
        return $this->belongsTo(Team::class,'createdByTeamId','_id');
    }
    public function operationManage(){
        return $this->belongsTo(Team::class,'operationManagerId','_id');
    }
    public function attendance(){
        return $this->hasMany(Attendance::class, 'teamId','_id');
    }
    public function assignedTasks()
    {
        return $this->hasMany(AssignTask::class, 'addedTaskTeamId', '_id');
    }
}
