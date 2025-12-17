<?php

namespace App\Http\Controllers\Team;

use App\Exports\ClientExport;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\ERP\AssignTask;
use App\Models\ERP\AssignTaskReplay;
use App\Models\ERP\Branch;
use App\Models\ERP\Client;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Cast\Object_;

class TeamTaskPulsControllers extends Controller
{
    public function unassignedClient(Request $req){
        $branchId = null;
        $teamId   = null;
        $adminId = null;
        if(session()->has('admin')){
            $adminId = session()->get('admin')->_id;
        }
        if(session()->has('team')){
            $branchId = session()->get('team')->branchId;
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
        if(session()->has('team')){
            // $branchId = session()->get('team')->branchId;
            $teamId = session()->get('team')->_id;
        }
       
        $List = Client::with('salseData','leadFollowupData','createdTeam','operationManagerTeam')->when(isset($branchId), function($query) use($branchId){
                   $query->where("branchId",new ObjectId($branchId))
                            ->when(session()->has('branch'), function($q){
                                $q->whereNull('assignToOpsManagerId');
                            });
               })
               ->when($adminId, function($query) use($adminId){
                        $query->whereNull('assignToOpsManagerId');
                })
               ->when($req->fromDate && $req->toDate, function($query) use($req){
                     $query->whereBetween('created_at', 
                       [
                           Carbon::parse($req->fromDate)->startOfDay(), 
                           Carbon::parse($req->toDate)->endOfDay()
                           ]
                   );
               })
               ->when($req->phoneNo, function($query) use($req){
                     $query->where("phoneNo","like","%".$req->phoneNo."%");
               })
               ->when(!empty($teamId), function($query) use($teamId){
                    if(session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c' || session()->has('team') && session()->get('team')->department=='67bd3cd7d4de44c0093ea46d'){
                        // sub admin or sub branch login
                        $query->whereNull('assignToOpsManagerId');
                    }else{
                        // assign by admin , team and self cilent
                        $teamIds = Team::where('operationManagerId', new ObjectId($teamId))->pluck('_id')->toArray();
                        $teamIds = array_map(fn($id) => new ObjectId($id), $teamIds);
                       
                        $query->where(function ($q) use ($teamId, $teamIds) {
                            $q->where('assignAdminByOperationManager', new ObjectId($teamId))
                                ->orWhere('assignToOpsManagerId', new ObjectId($teamId))
                                ->orWhere('createdByTeamId', new ObjectId($teamId))
                                ->orWhereIn('createdByTeamId', $teamIds);
                        });
                        
                    }
                })
               ->whereNull('assignOperationId')
               ->latest()
               ->paginate(20);
              
            $brnachList = [];
            if(session()->has('branch')){
                $branchId = session()->get('branch')->_id;
                $brnachList = Branch::where('status', "1")
                    ->whereNotIn('_id', [new ObjectId($branchId)])
                    ->orderBy('branch_name','ASC')->get();
            }

        return view('team.task-pulse.unassigned-client', compact('List','brnachList'));
    }

    public function taskFlowReport(Request $req){
        $branchId = null;
        $teamId = null;
        if(session()->has('team')){
            // $branchId = session()->get('team')->branchId;
            $teamId = session()->get('team')->_id;
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
       
        $List = Client::with(['salseData','leadFollowupData','assigntask','operationTeam','branches'])
               ->when(!empty($branchId), function($query) use($branchId){
                   $query->where("branchId",new ObjectId($branchId));
               })
               ->when(!empty($teamId), function($query) use($teamId){
                $team = session()->get('team');
                //sub admin and sub brnach check
                    if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                        $query->where("branchId",new ObjectId($team->branchId));
                     }else{
                        $query->where("assignAdminByOperationManager",new ObjectId($teamId))
                            ->orWhere('createdByTeamId',new ObjectId($teamId))
                            ->orWhere('assignByTeamId', new ObjectId($teamId))
                            ->orWhere('assignOperationId', new ObjectId($teamId));
                     }      
                })
               ->when($req->fromDate && $req->toDate, function($query) use($req){
                       return $query->whereBetween('created_at', 
                       [
                           Carbon::parse($req->fromDate)->startOfDay(), 
                           Carbon::parse($req->toDate)->endOfDay()
                           ]
                   );
               })
               ->when($req->phoneNo, function($query) use($req){
                     $query->where("phoneNo","like","%".$req->phoneNo."%");
               })
               ->when($req->client && !empty($teamId), function($query) use($teamId){
                        $query->where("assignOperationId", new ObjectId($teamId));
                                // ->orWhere('assignByTeamId', new ObjectId($teamId))
                                // ->orWhere('createdByTeamId', new ObjectId($teamId));
                })
                ->whereNotNull('assignOperationId')->latest(); // opertion team assing by manager
                if(!empty($req->excel)){
                    $ListExcel = $List->get();
                    return Excel::download(new ClientExport($ListExcel), 'Client_' . date('d-m-Y') . '.xlsx');
                }
                $List = $List->paginate(20);
              
                
        return view('team.task-pulse.taskflow-report', compact('List'));
    }
    public function taskPulse(Request $req){
        $branchId = null;
        $teamId = null;
        if(session()->has('team')){
            // $branchId = session()->get('team')->branchId;
            $teamId = session()->get('team')->_id;
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
       
       
        $clientId = Client::when(!empty($branchId), function($query) use($branchId){
                   $query->where("branchId",new ObjectId($branchId));
               })
               ->when(!empty($teamId), function($query) use($teamId){
                    $query->where("assignOperationId",new ObjectId($teamId));
                })
                ->pluck('_id')
                ->map(fn($id) => new ObjectId($id)) // Ensure all IDs are ObjectId instances
                ->toArray();

                $AssignTask = AssignTask::with(['addTaskByTeam','client','addTaskToTeam'])
                            ->when(!empty($clientId), function($query) use($clientId){
                                $query->whereIn("clientId", $clientId);
                            })

                            ->when(!empty($req->fromDate) && !empty($req->toDate), function($query) use ($req) {
                                $query->whereBetween('created_at', [
                                    Carbon::parse($req->fromDate)->startOfDay(),
                                    Carbon::parse($req->toDate)->endOfDay()
                                ]);
                            })
                            
                            ->when(!empty($req->mobileNo), function($query) use ($req) {
                                $query->where('client.phoneNo', $req->mobileNo);
                            })
                            
                            ->when(!empty($req->taskStatus), function($query) use ($req) {
                                $query->where('taskStatus', $req->taskStatus);
                            })
                            
                            ->orderBy('updated_at','desc')
                            ->paginate(10);
                            
                         
        return view('team.task-pulse.task-pulse', compact('AssignTask'));
    }
    
    public function taskReply(Request $req){
        $uploadImage = null;
        if($req->has('uploadImage')){
            $dir = "task-reply";
            $uploadImage = Helpers::imageResize($req->uploadImage, null, null, $dir);
            
        }
     
        $data = [
            'clientId'         => new ObjectId($req->clientId),
            'operatinId'       => new ObjectId(session()->get('team')->_id),
            'assignByTeamId'   => !empty($req->assignByTeamId) ? new ObjectId($req->assignByTeamId) : null,
            'assignByBranchId' => !empty($req->assignByBranchId) ? new ObjectId($req->assignByBranchId) : null,
            'assignByAdminId'  => !empty($req->assignByAdminId) ? new ObjectId($req->assignByAdminId) : null,
            'taskId'           => new ObjectId($req->taskId),
            'spentTime'        => (double) $req->spentTime,
            'remarks'          => $req->remarks,
            'taskStatus'       => $req->status,
            'uploadImage'      => $uploadImage
        ];

        AssignTaskReplay::create($data);
        AssignTask::where('_id', new ObjectId($req->taskId))->update(['taskStatus' => $req->status]);
        return back()->with('success','Reply successfully');
    }
    public function taskGiven(Request $req){
        $branchId = null;
        $teamId = null;
        if(session()->has('team')){
            $teamId = session()->get('team')->_id;
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
      
        $clientId = Client::when(!empty($branchId), function($query) use($branchId){
                    $query->where("branchId",new ObjectId($branchId));
                })
                ->when(!empty($teamId), function($query) use($teamId){
                    $team = session()->get('team');
                    //sub admin and sub brnach check
                        if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                            $query->where("branchId",new ObjectId($team->branchId));
                        }else{
                            $query->where("assignAdminByOperationManager",new ObjectId($teamId))
                                ->orWhere('createdByTeamId',new ObjectId($teamId))
                                ->orWhere('assignByTeamId', new ObjectId($teamId))
                                ->orWhere('assignOperationId', new ObjectId($teamId));
                        }      
                    })
                    ->pluck('_id')
                    ->map(fn($id) => new ObjectId($id)) // Ensure all IDs are ObjectId instances
                    ->toArray();
                    
        $AssignTask = AssignTask::with(['addTaskByTeam','client','addTaskToTeam'])
                            ->when(!empty($clientId), function($query) use($clientId){
                                $query->whereIn("clientId", $clientId);
                            })

                            ->when(!empty($req->fromDate) && !empty($req->toDate), function($query) use ($req) {
                                $query->whereBetween('created_at', [
                                    Carbon::parse($req->fromDate)->startOfDay(),
                                    Carbon::parse($req->toDate)->endOfDay()
                                ]);
                            })
                            
                            ->when(!empty($req->mobileNo), function($query) use ($req) {
                                $query->where('client.phoneNo', $req->mobileNo);
                            })
                            
                            ->when(!empty($req->taskStatus), function($query) use ($req) {
                                $query->where('taskStatus', $req->taskStatus);
                            })
                            ->when(!empty($req->client) && $teamId, function($query) use ($teamId) {
                                  $query->where('addedTaskTeamId','=', new ObjectId($teamId));
                            })
                            ->when(!empty($req->dashboardData), function($query) use ($req) {
                                if($req->dashboardData == 'newTask'){
                                    $query->where('taskStatus','=', 'Not Started');
                                }
                                if($req->dashboardData == 'pendingTask'){
                                    $query->whereIn('taskStatus', ['Not Started', 'In Progress']);
                                }
                                if($req->dashboardData == 'closedTask'){
                                    $query->where('taskStatus','=', 'Completed');
                                }
                                if($req->dashboardData == 'activeTask'){
                                    $query->where('taskStatus','=', 'In Progress');
                                }
                            })
                            ->orderBy('updated_at','desc')
                            ->paginate(10);
                          
            
        return view('team.task-pulse.given-task', compact('AssignTask'));
    }
    public function untuchedClient(Request $req){
        $branchId = null;
        $teamId = null;
        if(session()->has('team')){
            // $branchId = session()->get('team')->branchId;
            $teamId = session()->get('team')->_id;
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
       
        $List = Client::with(['salseData','leadFollowupData','assigntask','operationTeam','operationManagerTeam'])
               ->when(!empty($branchId), function($query) use($branchId){
                   $query->where("branchId",new ObjectId($branchId));
               })
               ->when(!empty($teamId), function($query) use($teamId){
                $team = session()->get('team');
                //sub admin and sub branch check
                    if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                        $query->where("branchId",new ObjectId($team->branchId));
                     }else{
                        $query->where("assignAdminByOperationManager",new ObjectId($teamId))
                            ->orWhere('createdByTeamId',new ObjectId($teamId))
                            ->orWhere('assignByTeamId', new ObjectId($teamId))
                            ->orWhere('assignOperationId', new ObjectId($teamId));
                     }      
                })
               ->when($req->fromDate && $req->toDate, function($query) use($req){
                       return $query->whereBetween('created_at', 
                       [
                           Carbon::parse($req->fromDate)->startOfDay(), 
                           Carbon::parse($req->toDate)->endOfDay()
                           ]
                   );
               })
               ->when($req->phoneNo, function($query) use($req){
                     $query->where("phoneNo","like","%".$req->phoneNo."%");
               })
               ->when($req->client && !empty($teamId), function($query) use($teamId){
                        $query->where("assignOperationId", new ObjectId($teamId));
                                // ->orWhere('assignByTeamId', new ObjectId($teamId))
                                // ->orWhere('createdByTeamId', new ObjectId($teamId));
                })
                ->whereNull('assignOperationId') // manager assigned form our team
                ->WhereNotNull('assignToOpsManagerId') // assign by admin or branch
                ->latest()->paginate(20);
            //   dd($List);

        return view('team.task-pulse.untouched-client', compact('List'));
    }
    public function moveToOtherBranch(Request $req){
        $branchData = explode('|', $req->branchId);
        $countryName = $branchData[0];
        $branchId    = $branchData[1];
       
        Client::where('_id', new ObjectId($req->clientId))->update([
            'moveFromBranchId' => new ObjectId($req->moveFromBranchId),
            'branchId'         => new ObjectId($branchId),
            'countryName'      => $countryName,
            'moveDate'         =>  date('Y-m-d'),
        ]);

        return back()->with('success','Client moved to other branch');
    }
    public function moveBranchTaskFlowReport(Request $req){
        $branchId = null;
        $teamId = null;
        // if(session()->has('team')){
        //     // $branchId = session()->get('team')->branchId;
        //     $teamId = session()->get('team')->_id;
        // }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
        }
       
       
        $List = Client::with(['salseData','leadFollowupData','assigntask','operationTeam','branches'])
               ->when(!empty($branchId), function($query) use($branchId){
                   $query->where("moveFromBranchId",new ObjectId($branchId));
               })
               ->when($req->fromDate && $req->toDate, function ($query) use ($req) {
                    return $query->whereBetween('moveDate', [
                        $req->fromDate,
                        $req->toDate,
                    ]);
                })
               ->when($req->phoneNo, function($query) use($req){
                     $query->where("phoneNo","like","%".$req->phoneNo."%");
               })
                ->when($req->client, function($query) use($req){
                    $query->whereNotNull('assignOperationId');
                });
                if(!empty($req->excel)){
                    $ListExcel = $List->get();
                    return Excel::download(new ClientExport($ListExcel), 'Client_' . date('d-m-Y') . '.xlsx');
                }
                $List = $List->orderBy('updatedAt','desc')->paginate(20);
            
                
        return view('team.task-pulse.move-other-brach-client-report', compact('List'));
    }
}
