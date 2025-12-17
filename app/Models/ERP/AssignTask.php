<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;
class AssignTask extends Model
{
    protected $collection = "crm_assignTask";
    protected $fillable = ["clientId","oprationId","assignByTeamId","assignByBranchId","assignByAdminId","taskHeading","taskDescription","compationDate","complationTime","taskStatus","addedTaskTeamId","addedTaskAdminId","addedTaskBranchId"];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId', '_id');
    }
    public function addTaskByTeam(){
        return $this->belongsTo(Team::class, 'addedTaskTeamId', '_id');
    }
    public function addTaskToTeam(){
        return $this->belongsTo(Team::class, 'oprationId', '_id');
    }
    public function replyTask(){
        return $this->hasMany(AssignTaskReplay::class, 'taskId', '_id');
    }
}
