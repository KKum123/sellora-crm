<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;
class AssignTaskReplay extends Model
{
    protected $collection = "crm_assignTaskReply";
    protected $fillable = ["taskId","clientId","operatinId","assignByTeamId","assingByBranchId","assignByAdminId","spentTime","remarks","taskStatus","uploadImage"];

    

}
