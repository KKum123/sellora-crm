<?php

namespace App\Models;
use App\Models\ERP\Team;
use Jenssegers\Mongodb\Eloquent\Model;

class TaskAdminBranch extends Model
{
    protected $collection = "crm_taskAdminBranch";
    protected $fillable = ['teamId','taskTitle','taskDetails','completionTime','taskRole','adminId','branchId','taskStatus'];

    public function team(){
        return $this->hasOne(Team::class, "_id", "teamId");
    }
    public function replyTask1(){
        return $this->hasMany(ReplyTaskAdminBaranch::class, 'taskId', '_id');
    }
}
