<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\ERP\Branch;
use App\Models\ERP\Client;
use App\Models\ERP\Country;
use App\Models\ERP\FollowUpLead;
use App\Models\ERP\Lead;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use App\Helpers\Helpers;
use Carbon\Carbon;

class AdminLeadAddControllers extends Controller
{
    public function addLead(Request $req){
        $branch_id = null;
        $country = Country::get();
        $branch = Branch::where('status', '1')->orderBy('branch_name','asc')->get();
        if(session()->has('team')){
            $branch_id = session()->get('team')->branchId;
        }
        if(session()->has('branch')){
            $branch_id = session()->get('branch')->_id;
        }

        if(session()->has( 'admin')){
            $sales = [];
        }else{
            $sales = Team::when($branch_id, function($query) use($branch_id){
                $query->where('branchId', new ObjectId($branch_id));
            })->where('status','1')->where('department', new ObjectId('6790b8962ef8f2064c61d076'))->orderBy('name','asc')->get();
          
        }

        $countryList = Helpers::countryOrCode();
      
        return view('admin.lead.add-lead', compact('countryList','country','branch','sales'));
    }
    public function saveLead(LeadRequest $req){
        $inputArr = $req->except('_token');
        
        if($req->assign_to_sales){
            $inputArr['assign_to_sales'] = new ObjectId($req->assign_to_sales);
        }
        if(isset($req->branch)){
            $inputArr['branch'] = new ObjectId($req->branch);
        }
        if(session()->has('admin')){
            $prefix = 'admin';
            $inputArr['assign_to_sales'] = null;
                if($req->assign_to_sales){
                    $inputArr['unassignTeamId'] = new ObjectId($req->assign_to_sales); // if admin assign lead refelect unassign lead
                }
        }
        if(session()->has('team')){
            $prefix = 'team';
            $inputArr['branch'] = new ObjectId(session()->get('team')->branchId);
            $inputArr['country'] = Branch::where('_id', session()->get('team')->branchId)->value('country') ?? null;
            $team = session()->get('team');
            //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                    $inputArr['assign_to_sales'] = null;
                    if($req->assign_to_sales){
                         $inputArr['unassignTeamId'] = new ObjectId($req->assign_to_sales);
                    }
                }
        }
        if(session()->has('branch')){
            $prefix = 'branch';
            $inputArr['branch']  = new ObjectId(session()->get('branch')->_id);
            $inputArr['country'] = session()->get('branch')->country;
            $inputArr['assign_to_sales'] = null;
            if($req->assign_to_sales){
                $inputArr['unassignTeamId'] = new ObjectId($req->assign_to_sales); // if branch assign lead refelect unassign lead
            }
        }
        
        
        if($req->id){
            Lead::where('_id', $req->id)->update($inputArr);
            $message = "Updated successfully";
        }else{
            if(session()->has('admin')){
                $inputArr['admin_id'] = new ObjectId(session()->get('admin')->id);
                
            }
            if(session()->has('team')){
                $inputArr['careatedTeamId'] = new ObjectId(session()->get('team')->id);
                 
            }
            if(session()->has('branch')){
                $inputArr['createdBranchId'] = new ObjectId(session()->get('branch')->id);
                
            }
           
            $count = Lead::count();
            $inputArr['request_id'] = 'SLR0' . str_pad($count, 4, '0', STR_PAD_LEFT);
            
            Lead::create($inputArr);
            $message = "Added successfully";
        }

        return back()->with("success", $message);
        // return redirect(route($prefix.'.lead.listLead'))->with('success', $message);
    }
    public function listLead(Request $req){

        $admin_id = session()->has('admin') ? session()->get('admin')->id : '';
        $branch_id = session()->has('branch') ? session()->get('branch')->id : '';
        $team_id  = session()->has('team') ? session()->get('team')->id : '';
        
        
       

        $List =  Lead::when($admin_id, function($query) use($admin_id){
           
           return $query->where('admin_id', new ObjectId($admin_id))
                        ->whereNull('unassignTeamId');
        })
        ->when($branch_id, function($query) use($branch_id){
           return $query->where('branch', new ObjectId($branch_id))
                        ->whereNull('unassignTeamId');
        })
        ->when($team_id, function($query) use($team_id){
            $team = session()->get('team');
            //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                    return $query->where('careatedTeamId', new ObjectId($team_id))
                            ->whereNull('unassignTeamId');
                }else{
                    return $query->where('careatedTeamId', new ObjectId($team_id))
                                 ->orWhere('unassignTeamId',new ObjectId($team_id));
                }
            
        })
        ->when($req->from_date && $req->to_date, function($query) use($req){
            $query->whereBetween('created_at', [
                Carbon::parse($req->from_date)->startOfDay(),
                Carbon::parse($req->to_date)->endOfDay()     
            ]);
        })
        ->when($req->mobile, function($query) use($req){
            $query->where('phone', $req->mobile);
        })
        ->whereNull('assign_to_sales')
        ->latest()->paginate(20);
      
        if(session()->has('team')){
            $branch_id = session()->get('team')->branchId;
        }
        if(session()->has('branch')){
            $branch_id = session()->get('branch')->_id;
        }

        
        
        return view('admin.lead.lead-list', compact('List'));
    }
    public function updateLead($id){
        $country = Country::get();
        
        if(session()->has('team')){
            $branch_id = session()->get('team')->branchId;
        }
        if(session()->has('branch')){
            $branch_id = session()->get('branch')->_id;
        }

        
        $singleData = Lead::find($id);
        if(session()->has(key: 'admin')){
            $sales = Team::where('branchId', new ObjectId($singleData->branch))->where('status','1')->where('department', new ObjectId('6790b8962ef8f2064c61d076'))->orderBy('name','asc')->get();
        }else{
            $sales = Team::when($branch_id, function($query) use($branch_id){
                $query->where('branchId', new ObjectId($branch_id));
            })->where('status','1')->where('department', new ObjectId('6790b8962ef8f2064c61d076'))->orderBy('name','asc')->get();
          
        }
        $branch = Branch::where('country', $singleData->country)->where('status', '1')->orderBy('branch_name','asc')->get();
       
        return view('admin.lead.add-lead', compact('country','branch','sales','singleData'));
    }
    public function deleteLead($id){
        Lead::where('_id', $id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
    public function leadTrack(Request $req){
        $admin_id = session()->has('admin') ? session()->get('admin')->id : '';
        $branch_id = session()->has(key: 'branch') ? session()->get('branch')->id : '';
        $team_id  = session()->has('team') ? session()->get('team')->id : '';
        
        $sale = Team::where(['department'=> new ObjectId('6790b8962ef8f2064c61d076'),'status'=>'1'])
                ->when($branch_id, function ($query) use ($branch_id) {
                    $query->where('branchId', $branch_id);
                })
                ->orderBy('name','asc')->get();
        
        $List = Lead::with(['assignedTeam','branches','leadCreateBy'])
        ->when($branch_id, function ($query) use ($branch_id) {
            return $query->where('branch', new ObjectId($branch_id));
        })
        ->when($team_id, function ($query) use ($team_id) {
            $team = session()->get('team');
                //sub admin and sub brnach check
                    if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                        $query->where("branch",new ObjectId($team->branchId));
                     }else{
                        if(session()->get('team')->designation == new ObjectId('6790b9662ef8f2064c61d07e')){    ///slase manager
                            // sales manager

                            $query->whereIn(
                                'careatedTeamId', 
                                Team::where('createdByTeamId', new ObjectId($team_id))
                                    ->pluck('_id')
                                    ->map(fn($id) => new ObjectId($id))
                                    ->toArray()
                                )->OrWhere('careatedTeamId', new ObjectId($team_id))
                                ->OrWhere('unassignTeamId', new ObjectId($team_id))
                                ->OrWhere('assign_to_sales', new ObjectId($team_id));       
                        }else{
                            return $query->where('careatedTeamId', new ObjectId($team_id))
                                ->OrWhere('unassignTeamId', new ObjectId($team_id))
                                ->OrWhere('assign_to_sales', new ObjectId($team_id));
                        }
                    }
        })
        ->when(!empty($req->fromDate) && !empty($req->toDate), function ($query) use ($req) {
            return $query->whereBetween('created_at', [
                Carbon::parse($req->fromDate)->startOfDay(),
                Carbon::parse($req->toDate)->endOfDay()
            ]);
        })
        ->when($req->phone, function ($query) use ($req) {
            return $query->where('phone', $req->phone);
        })
        ->when($req->projectStatus, function ($query) use ($req) {
            
            return $query->where(function ($q) use ($req) {
                if ($req->projectStatus == 'Pending') {
                    $q->where('projectStatus', 'Pending')
                      ->orWhereNull('projectStatus');
                } else {
                    $q->where('projectStatus', $req->projectStatus);
                }
            });

        })
        ->when(!empty($req->dashboardStatus), function($query) use($req){
            if($req->dashboardStatus=='newLead'){
                return $query->whereNull('projectStatus');
            }
            if($req->dashboardStatus=='activeLead'){
                return $query->whereIn('projectStatus', ['Pitch In Progress','In Progress']);
            }
            if($req->dashboardStatus=='pendingLead'){
                return $query->where(function ($q) use ($req) {
                   
                        $q->whereIn('projectStatus', ['Pitch In Progress','In Progress','Pending'])
                          ->orWhereNull('projectStatus');
                 
                });
                
            }
            if($req->dashboardStatus=='salseCloseLead'){
                return $query->whereIn('projectStatus', ['Not Reachable','Not Interested','Cancelled']);
            }
            if($req->dashboardStatus=='closedLead'){
                return $query->where('projectStatus', 'Completed');
            }
        })
        ->whereNotNull('assign_to_sales')
        ->latest()
        ->paginate(20);
        
        
        // dd($List);
        return view('admin.lead.lead-track', compact('sale','List'));
    }

    
    public function myLead(Request $req){
        $team_id = session()->has('team') ? session()->get('team')->id :'';
        
        $List = Lead::with( 'leadFollowUp')
        ->when(!empty($req->fromDate) && !empty($req->toDate), function($query) use($req){
            return $query->whereBetween('created_at', 
            [
                Carbon::parse($req->fromDate)->startOfDay(), 
                Carbon::parse($req->toDate)->endOfDay()
                ]
        );
        })
        ->when($req->phone, function($query) use($req){
            return $query->where('phone', $req->phone);
        })
        ->when($req->projectStatus, function($query) use($req){
            return $query->where('projectStatus', $req->projectStatus);
        })
        ->where('assign_to_sales', operator: new ObjectId($team_id))->latest()->paginate(20);
      
        return view('admin.lead.my-lead', compact('List'));
       
    }
    public function assignLead(Request $req){
        $assign_to_sales = new ObjectId($req->assign_to_sales);
        $unassignTeamId = null;
        if(session()->has('admin')){
                $unassignTeamId = new ObjectId($req->assign_to_sales); // if admin assign lead refelect unassign lead
           }
        if(session()->has('team')){
             $team = session()->get('team');
            //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                   $unassignTeamId = new ObjectId($req->assign_to_sales);
                 }
        }
        if(session()->has('branch')){
                $unassignTeamId = new ObjectId($req->assign_to_sales);
          }
        if($unassignTeamId){
            Lead::where('_id', new ObjectId($req->leadId))->update([
                'assign_to_sales'=> null,
                'unassignTeamId' => $unassignTeamId,
            ]);
        }else{
            Lead::where('_id', new ObjectId($req->leadId))->update([
                'assign_to_sales' => $assign_to_sales,
            ]);
        }

        return back()->with('success','Assigned Successfully');
    }
    public function saveFollowUpLead(Request $req){
        
        $inputArr = $req->except('_token');
        $inputArr['leadId'] = new ObjectId($req->leadId);
        if(session()->has('admin')){
            $adminId = new ObjectId(session()->get('admin')->id);
            $inputArr['admin_id'] = $adminId;
        }
        if(session()->has('team')){
            $teamId = new ObjectId(session()->get('team')->id);
            $inputArr['teamId'] = $teamId;
            $inputArr['teamBranchId'] = new ObjectId(session()->get('team')->branchId);
            
        }
        if(session()->has('branch')){
            $BranchId = new ObjectId(session()->get('branch')->id);
            $inputArr['branchId'] = $BranchId;
                
        }
        
        Lead::where('_id', new ObjectId($req->leadId))->update(['projectStatus'=>$req->projectStatus]);
        FollowUpLead::create($inputArr);
        
        if($req->projectStatus=='Completed'){
           
           $leadData =  Lead::find(new ObjectId($req->leadId));

           $requestId = 'SLR' . str_pad($count, 4, '0', STR_PAD_LEFT);

                    $data = [
                                "leadId" => new ObjectId($leadData->_id),
                                "countryName" => $leadData->country,
                                "branchId" => new ObjectId($leadData->branch),
                                "leadRequestId" => $leadData->request_id,
                                "requestId" => $requestId,
                                "requestName" => $leadData->requester_name,
                                "phoneNo"=>$leadData->phone,
                                "emailId" => $leadData->email,
                                "city" => $leadData->city,
                                "serviceCategory" => $leadData->service_category,
                                "requestLocation" => $leadData->requester_location,
                                "requestSellCountry" => $leadData->requester_sell_in_country,
                                "assignOperationManager" => null,
                                "noteFromRequest" => $leadData->note_from_requester,
                                "jobTitle" => $leadData->job_title,
                                "moveByTeamId" => isset($teamId) ? $teamId : null,
                                "moveByBranchId" => isset($BranchId) ? $BranchId : null,
                                "moveByAdminId" => isset($adminId) ? $adminId : null,
                                "status" => '1',
                                "countryCode" => !empty($leadData->countryCode) ? $leadData->countryCode : ''
                    ];
           
            Client::create($data);
        }
        return back()->with('success','Follow up successfully');
    }
}
