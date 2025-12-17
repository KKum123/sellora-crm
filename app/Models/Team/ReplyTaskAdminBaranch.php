<?php

namespace App\Models;


use App\Models\ERP\Team;
use Jenssegers\Mongodb\Eloquent\Model;

class ReplyTaskAdminBaranch extends Model
{
    protected $table = "crm_replyTaskAdminBranch";
    protected $fillable = ["teamId","taskStatus","taskId","timeSpend","taskReply"];
}
