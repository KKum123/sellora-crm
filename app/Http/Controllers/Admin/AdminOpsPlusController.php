<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientValidation;
use App\Models\ERP\AssignClient;
use App\Models\ERP\AssignTask;
use App\Models\ERP\Branch;
use App\Models\ERP\Client;
use App\Models\ERP\Country;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use App\Helpers\Helpers;

class AdminOpsPlusController extends Controller
{
    public function OpsPulsManager(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
         if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
         }else{
            $branchId = $req->branch_id;
         }
         if(session()->has('team')){
            $team = session()->get('team');
            //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                   $branchId = new ObjectId($team->branchId);
                 }
         }
       
        $List = Team::with('branches')->when($branchId, function($query) use ($branchId){
            $query->where("branchId",new ObjectId($branchId));
        })
        ->when($req->name, function($query) use ($req){
            $query->where("name","like","%".$req->name."%");
        })
        ->when($req->email, function($query) use ($req){
            $query->where("email","like","%".$req->email."%");
        })
        ->where("designation",new ObjectId('6797015d1af1e9898db5951d'))
         //operation manager
        ->latest()->paginate(20);
       

        return view('admin.ops-puls.ops-puls-manager', compact('branch','List'));
    }
    public function OpsPulsTeam(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        $branchId = '';
        if(session()->has('team')){
            $team = session()->get('team');
            //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                   $branchId = new ObjectId($team->branchId);
                 }
         }

        $List = Team::with('branches')->when($req->branchId, function($query) use ($req){
            $query->where("branchId",new ObjectId($req->branchId));
        })
        ->when($branchId, function($query) use ($branchId){
            $query->where("branchId",$branchId);
        })
        ->when($req->name, function($query) use ($req){
            $query->where("name","like","%".$req->name."%");
        })
        ->when($req->email, function($query) use ($req){
            $query->where("email","like","%".$req->email."%");
        })
        ->where("department",new ObjectId('6790b8b82ef8f2064c61d077'))#opeartion team
        ->whereNotIn('designation',[new ObjectId('6797015d1af1e9898db5951d')])->latest()->paginate(20);
 

        return view('admin.ops-puls.ops-puls-team', compact('branch','List'));
    }
    public function OpsPulsReport(){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        
        return view('admin.ops-puls.ops-puls-report', compact('branch'));
    }
    public function addClient(){
        $branchId = null;
        if(session()->has('branch')){
            $branchId = new ObjectId(session()->get('branch')->_id);
        }
        if(session()->has('team')){
            $branchId = new ObjectId(session()->get('team')->branchId);
        }
        $country =  Country::get();
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        $team = Team::where("status","1")
                ->when($branchId, function($query) use ($branchId){
                    $query->where("branchId","=", $branchId);
                })
                ->where('designation', new ObjectId('6797015d1af1e9898db5951d')) //Operation Manager 
                ->orderBy("name",'asc')->get();
                if(session()->has('admin')){
                    $team = [];
                }

                $countryList = Helpers::countryOrCode();

        return view('admin.ops-puls.add-client', compact('countryList','country','branch','team'));
    }
    public function cSaveClient(ClientValidation $req){
       
        if(session()->has('admin')){
            $prefix = 'admin';
        }else if(session()->has('branch')){
            $prefix = 'branch';
        }else if(session()->has('team')){
            $prefix = 'team';
        }

        $inputArr = $req->except('_token');
        if($req->id){
           
            Client::where('_id', new ObjectId($req->id))->update($inputArr);
          
            $message = 'Updated Successfully';
        }else{
            $inputArr['assignToOpsManagerId'] = !empty($req->assignAdminByOperationManager) ? $req->assignAdminByOperationManager : null;
            
            if(!empty($req->assignAdminByOperationManager)){
                $inputArr['assignAdminByOperationManager'] = new ObjectId($req->assignAdminByOperationManager);
                $inputArr['assignToOpsManagerId'] = new ObjectId($req->assignAdminByOperationManager);
            }

            if(session()->has('admin')){
                $inputArr['createdByAdminId'] = new ObjectId(session()->get('admin')->_id);
                $inputArr['assignAdminByOperationManager'] = new ObjectId($req->assignAdminByOperationManager);
                $inputArr['branchId'] =  new ObjectId($req->branchId);
                
            }else if(session()->has('branch')){
                $inputArr['createdByBranchId'] = new ObjectId(session()->get('branch')->_id);
                $inputArr['countryName'] = session()->get('branch')->country;
                $inputArr['branchId'] = new ObjectId(session()->get('branch')->_id);
                $inputArr['assignAdminByOperationManager'] = new ObjectId($req->assignAdminByOperationManager);

            }else if(session()->has(key: 'team')){
                $teamData = Team::where( '_id', new ObjectId(session()->get('team')->_id))->first();
                $inputArr['createdByTeamId'] = new ObjectId(session()->get('team')->_id);
                $inputArr['countryName'] = !empty($teamData->branches) ? $teamData->branches->country : null;
                $inputArr['branchId'] =  new ObjectId(session()->get('team')->branchId);
                if(session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->get('team')->department=='67bd3cd7d4de44c0093ea46d'){
                    //sub admin sub branch login
                    $assignToOpsManagerId = new ObjectId($req->assignAdminByOperationManager);
                    $inputArr['assignToOpsManagerId'] = $assignToOpsManagerId;
                }else{
                    // team add lead auto add operaton manager unassign 
                    $inputArr['assignToOpsManagerId'] =  !empty($teamData->operationManagerId) ? new ObjectId($teamData->operationManagerId) : null;
                    if(session()->get('team')->designation == '6797015d1af1e9898db5951d'){
                        // operation manager
                        $inputArr['assignToOpsManagerId'] =  new ObjectId($teamData->_id);
                    }
                }
            }
          
            $count = Client::count();
            $inputArr['requestId'] = 'SLR' . str_pad($count, 4, '0', STR_PAD_LEFT);
            
            Client::create($inputArr);

            $message = 'Created Successfully';
        }
       
        return back()->with('success', $message);
        // return redirect(route($prefix.'.task-pulse.unassignedClient'))->with('success', $message);
    }
    public function moveToTeam(Request $req){
        $assignToOpsManagerId = null;
        $assignOperationId = null;
        if(session()->has('team')){
            $teamId = new ObjectId(session()->get('team')->_id);
            //sub admin / sub branch 
            if(session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->get('team')->department=='67bd3cd7d4de44c0093ea46d'){
                $assignToOpsManagerId = new ObjectId($req->assignOperationId);
            }else{
                $assignOperationId = new ObjectId($req->assignOperationId);
            }
        }
        if(session()->has('branch')){
            $branchId = new ObjectId(session()->get('branch')->_id);
            $assignToOpsManagerId = new ObjectId($req->assignOperationId);
        }
        if(session()->has('admin')){
            $adminId = new ObjectId(session()->get('admin')->_id);
            $assignToOpsManagerId = new ObjectId($req->assignOperationId);
        }
        Client::where('_id', new ObjectId($req->clientId))->update([
            'assignOperationId'=> !empty($assignOperationId) ? $assignOperationId : null,
            'assignToOpsManagerId'=> !empty($assignToOpsManagerId) ? $assignToOpsManagerId : null,
            'assignByTeamId'   => !empty($teamId) ? $teamId : null,
            'assingByBranchId' => !empty($branchId) ? $branchId : null,
            'assingByAdminId' => !empty($adminId) ? $adminId : null,
        ]);

        AssignClient::create([
            'assignOperationId' => $assignOperationId,
            'assignByTeamId'    => !empty($teamId) ? $teamId : null,
            'assingByBranchId'  => !empty($branchId) ? $branchId : null,
            'assingByAdminId'   => !empty($adminId) ? $adminId : null,
            'assignToOpsManagerId' => $assignToOpsManagerId
        ]);
        
        return back()->with('success','Moved team successfully');
    }
    public function updateClient($id){
        $singleData = Client::find($id);
        $country = Country::get();
        $branch = Branch::get();
        $team = Team::where('department',new ObjectId('679c4879e94326f5670c8e8b'))->where('status','1')->orderBy('name','asc')->get();
        return view('admin.ops-puls.add-client', compact('team','singleData','country','branch'));
      
    }
    public function deleteClient($id){
        Client::where('_id', new ObjectId($id))->delete();
        return back()->with('success','Deleted successfully');
    }

    public function assignTask(Request $req){
        $inputArr = $req->except('_token');
        if(session()->has('admin')){
            $inputArr['addedTaskAdminId']  = new ObjectId(session()->get('admin')->_id);
        }else if(session()->has('branch')){
            $inputArr['addedTaskBranchId'] = new ObjectId(session()->get('branch')->_id);
        }else if(session()->has('team')){
            $inputArr['addedTaskTeamId']   = new ObjectId(session()->get('team')->_id);
        }
        
        $inputArr['clientId'] = !empty($req->clientId) ?  new ObjectId($req->clientId) : null;
        $inputArr['assignByTeamId'] = !empty($req->assignByTeamId) ?  new ObjectId($req->assignByTeamId) : null;
        $inputArr['oprationId'] = !empty($req->assignOperationId) ?  new ObjectId($req->assignOperationId) : null;
        $inputArr['assingByAdminId'] = !empty($req->assingByAdminId) ?  new ObjectId($req->assingByAdminId) : null;
        $inputArr['assingByBranchId'] = !empty($req->assingByBranchId) ?  new ObjectId($req->assingByBranchId) : null;
        $inputArr['taskStatus'] = 'Not Started';
        $inputArr['complationTime'] = (double) $req->complationTime;
        $inputArr['updated_at'] = null;
       
        AssignTask::create($inputArr);
        
        return back()->with('success','Added task successfully');
    }
    public function assignTeamOperationManager(Request $req){
        $assignByAdminId  = null;
        $assignByTeamId   = null;
        $assignByBranchId = null;
        
        if(session()->has('admin')){
            $assignByAdminId = new ObjectId(session()->get('admin')->id); 
        }
        if(session()->has( 'team')){
            $assignByTeamId = new ObjectId(session()->get('team')->id);
        }
        if(session()->has( 'branch')){
            $assignByBranchId = new ObjectId(session()->get('branch')->id);
        }
      
        Team::where('_id', new ObjectId($req->teamId))->update([
            'assignOperationByAdminId' => $assignByAdminId,
            'assignOperationByTeamId'  => $assignByTeamId,
            'assignOperationByBranchId'=> $assignByBranchId,
            'operationManagerId' => new ObjectId($req->operationManagerId) /// assign to operation manager
        ]);
       
        return back()->with('success','Assigned team successfully');
    }
}
