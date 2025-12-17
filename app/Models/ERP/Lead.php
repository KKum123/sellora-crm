<?php

namespace App\Models\ERP;

use Google\Rpc\Context\AttributeContext\Request;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;

class Lead extends Model
{
    
    protected $collection = "crm_leads";
    protected $fillable = ['country','branch','request_id','requester_name','phone','email','city','service_category','requester_location','requester_sell_in_country','assign_to_sales','comments','note_from_requester','job_title','status','admin_id','branch_id','team_id','careatedTeamId','createdBranchId','projectStatus','unassignTeamId','countryCode'];
   
    // unassignTeamId means that the admin or branch assigns a lead to a salesperson, and the lead is then reflected in the unassigned module.

    public function leadFollowUp(){
        return $this->hasMany(FollowUpLead::class, 'leadId', '_id');
    }
    public function assignedTeam()
    {
        return $this->belongsTo(Team::class, 'assign_to_sales', '_id');
    }
    public function branches(){
        return $this->belongsTo(Branch::class,'branch','_id');
    }
    public function leadCreateBy()
    {
        return $this->belongsTo(Team::class, 'careatedTeamId', '_id'); 
    }
    public function branchFollowUp(){
        return $this->belongsTo(FollowUpLead::class, 'leadId', '_id');
    }
    public function assignByAdminOrBranch(){
        return $this->belongsTo(Team::class, 'unassignTeamId', '_id'); 
    }

}
