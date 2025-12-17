<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;

class AssignClient extends Model
{
    protected $collection = "crm_assignClients";
    protected $fillable = ['assignOperationId','assignByTeamId','assingByBranchId','assingByAdminId'];
}
