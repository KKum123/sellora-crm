<?php

namespace App\Models\ERP;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class FollowUpLead extends Model
{
   protected $collection = 'crm_followupLead';
   protected $fillable = ['leadId','FollowUpDate','projectStatus','remarks','teamId','branchId','admin_id','teamBranchId'];
   public function lead()
    {
        return $this->belongsTo(Lead::class, 'leadId', '_id');
    }
}
