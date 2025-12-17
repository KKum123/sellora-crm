<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadExport;
use App\Http\Controllers\Controller;
use App\Models\ERP\Branch;
use App\Models\ERP\Lead;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Maatwebsite\Excel\Facades\Excel;

class AdminSalesControllers extends Controller
{
    public function salePlusManager(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        $branchId = isset($req->branchId) ? $req->branchId : null;
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }else{
            $branchId = $req->branchId;
        }
        if(session()->has('team')){
            $team = session()->get('team');
            //sub branch and sub admin
            if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                  $branchId = $team->branchId;
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
                ->where("designation",new ObjectId('6790b9662ef8f2064c61d07e')) //Sales Manager 
                ->latest()
                ->paginate(20);
       
        return view('admin.sales.sales-pulse-manager', compact('branch','List'));
    }
    public function salePlusTeam(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
       
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }else{
            $branchId = $req->branchId;
        }
        if(session()->has('team')){
            $team = session()->get('team');
            //sub branch and sub admin
            if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                  $branchId = $team->branchId;
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
       ->where("department",new ObjectId('6790b8962ef8f2064c61d076'))#sales team
       #Not sales manager 
       ->whereNotIn('designation',[new ObjectId('6790b9662ef8f2064c61d07e')])
       ->latest()
       ->paginate(20);

        return view('admin.sales.sales-pulse-team', compact('branch','List'));
    }

    public function salePlusReport(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        $admin_id = session()->has('admin') ? session()->get('admin')->id : '';
        $branch_id = session()->has('branch') ? session()->get('branch')->id : '';
        $team_id  = session()->has('team') ? session()->get('team')->id : '';
        
        $sale = Team::where(['department'=> new ObjectId('6790b8962ef8f2064c61d076'),'status'=>'1'])
                ->when($branch_id, function($query) use($branch_id){
                    $query->where('branchId','=', $branch_id);
                })->orderBy('name','asc')->get();
        
            if(isset($req->branch_id)){
                $branch_id = $req->branch_id;
            }

        $List = Lead::with(['assignedTeam','branches'])
            ->when($branch_id, function ($query) use ($branch_id) {
                       $query->where('branch', new ObjectId($branch_id));
            })
            ->when($team_id, function ($query) use ($team_id) {
                $team = session()->get('team');
                 //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                    return $query->where('branch', new ObjectId($team->branchId));
                 }else{
                    return $query->where('branch', new ObjectId($team_id));
                 }
                
            })
            ->when(!empty($req->fromDate) && !empty($req->toDate), function ($query) use ($req) {
                return $query->whereBetween('created_at', [$req->fromDate, $req->toDate]);
            })
            ->when($req->email, function ($query) use ($req) {
                return $query->where('email', $req->email);
            })
            ->when($req->name, function ($query) use ($req) {
                $query->where('requester_name', 'like', '%' . $req->name . '%');
            })
            ->when($req->phone, function ($query) use ($req) {
                return $query->where('phone', $req->phone);
            })
            ->when($req->projectStatus, function ($query) use ($req) {
                return $query->where('projectStatus', $req->projectStatus);
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
        ->latest();
        if(!empty($req->excel)){
            $ListExcel = $List->get();
            return Excel::download(new LeadExport($ListExcel), 'lead_' . date('d-m-Y') . '.xlsx');
        }
        $List = $List->paginate(20);

        return view('admin.sales.sales-pulse-report', compact('branch','sale','List'));
    }
    public function assignTeamSalesManager(Request $req){
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
            'assignByAdminId' => $assignByAdminId,
            'assignByTeamId'  => $assignByTeamId,
            'assignByBranchId'=> $assignByBranchId,
            'createdByTeamId' => new ObjectId($req->salesManagerId)
        ]);
        return back()->with('success','Assigned team successfully');
    }

    public function untouched(Request $req){
        $branch = Branch::where("status", "1")->orderBy("branch_name","asc")->get();
        $admin_id = session()->has('admin') ? session()->get('admin')->id : '';
        $branch_id = session()->has('branch') ? session()->get('branch')->id : '';
        $team_id  = session()->has('team') ? session()->get('team')->id : '';
        
        $List = Lead::with(['assignedTeam','branches'])
            ->when($branch_id, function ($query) use ($branch_id) {
                       $query->where('branch', new ObjectId($branch_id));
            })
            ->when($team_id, function ($query) use ($team_id) {
                $team = session()->get('team');
                 //sub admin and sub brnach check
                if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                    return $query->where('branch', new ObjectId($team->branchId));
                 }else{
                    return $query->where('branch', new ObjectId($team_id));
                 }
                
            })
            ->when(!empty($req->fromDate) && !empty($req->toDate), function ($query) use ($req) {
                return $query->whereBetween('created_at', [$req->fromDate, $req->toDate]);
            })
            ->when($req->email, function ($query) use ($req) {
                return $query->where('email', $req->email);
            })
            ->when($req->name, function ($query) use ($req) {
                $query->where('requester_name', 'like', '%' . $req->name . '%');
            })
            ->when($req->phone, function ($query) use ($req) {
                return $query->where('phone', $req->phone);
            })
            ->when($req->projectStatus, function ($query) use ($req) {
                return $query->where('projectStatus', $req->projectStatus);
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
        ->whereNotNull('unassignTeamId')
        ->whereNull('assign_to_sales')
        ->latest()
        ->paginate(20);

        return view('admin.sales.untouched', compact('branch','List'));
    }
}
