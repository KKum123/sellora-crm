<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ERP\AssignTask;
use App\Models\ERP\AssignTaskReplay;
use App\Models\ERP\Attendance;
use App\Models\ERP\Client;
use App\Models\ERP\EmployeeRecognition;
use App\Models\ERP\FollowUpLead;
use App\Models\ERP\Lead;
use App\Models\ERP\NewHiresModel;
use App\Models\ERP\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class AdminDashboardControllers extends Controller
{
    public function dashboard(Request $req){
      $attendance = null;
      $dashboard = [];
      $graphData = [];
      $OpsPulse  = [];

      $date = Carbon::now()->format('Y-m-d');
      $startOfDay1 = Carbon::parse($date)->startOfDay()->setTimezone('UTC');
      $endOfDay1 = Carbon::parse($date)->endOfDay()->setTimezone('UTC');

      $startOfDay = new UTCDateTime($startOfDay1->timestamp * 1000);
      $endOfDay = new UTCDateTime($endOfDay1->timestamp * 1000);
      
        # Admin / Sub Admin 
       if (session()->has('admin') || session()->has('team') && session()->get('team')->department=='67bd3ca8d4de44c0093ea46c') {
            $team_id = null;
            $teamId  = null;
            
            if(session()->has('team')){
                $adminId = new ObjectId(session()->get('team')->_id);
                $team_id = $adminId;
                $teamId = $adminId;

                $attendance = Attendance::where('teamId', $adminId)
                    ->whereBetween('created_at', [$startOfDay, $endOfDay])
                    ->first();
            }
            

            $lead    = Lead::whereNotNull('assign_to_sales')
            ->when($team_id, function ($query) use ($team_id) {
                $team = session()->get('team');
                    //sub admin and sub brnach check
                        if($team->department == '67bd3ca8d4de44c0093ea46c' || $team->department == '67bd3cd7d4de44c0093ea46d'){
                            $query->where("branch",new ObjectId($team->branchId));
                         }else{
                            if(session()->get('team')->designation == new ObjectId('6790b9662ef8f2064c61d07e')){    ///slase manager
                                
                                $query->whereIn(
                                    'careatedTeamId', 
                                    Team::where('createdByTeamId', new ObjectId($team_id))
                                        ->pluck('_id')
                                        ->map(fn($id) => new ObjectId($id))
                                        ->toArray()
                            )->OrWhere('careatedTeamId', new ObjectId($team_id));
    
                            }else{
                                return $query->where('careatedTeamId', new ObjectId($team_id));
                            }
                        }
            })
            ->get();
            $sales   = FollowUpLead::get();

            $clientId = Client::when(!empty($teamId), function($query) use($teamId){
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

            $task = AssignTask::when(!empty($clientId), function($query) use($clientId){
                                $query->whereIn("clientId", $clientId);
                            })->get();
            $taskReply = AssignTaskReplay::get();
            
            // Assign to graph variable
           $noOfLeadAssign = $sales->unique('leadId')->count();;
           $converstionLead  = $sales->count();

           $lsr = $noOfLeadAssign > 0 ? $converstionLead / ($noOfLeadAssign * 100) : 0;
          
           $OpsPulse = [
                'newTask'     => $task->where('taskStatus','Not Started')->count(),
                'activeTask'  => $task->where('taskStatus','In Progress')->count(),
                'pendingTask' => $task->whereIn('taskStatus',['Not Started','In Progress'])->count(),
                'closedTask'  => $task->where('taskStatus','Completed')->count(),
                'totalTask'   => $task->count()
           ];
           
           $newLead = $lead->whereNull('projectStatus')
                            ->count();

           $activeLead = $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress'])->count();

            $dashboard = [
                'newLead'     => $newLead,
                'activeLead'  => $activeLead,
                'closeLead'   => $lead->where('projectStatus', 'Completed')->count(),
                'pendingLead' => $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress','Pending'])->count()+$newLead,
                'totalLead'   => $lead->count(),
                'lsr'         => $lsr,
                'salseClose'  => $lead->whereIn('projectStatus', ['Not Reachable','Not Interested','Cancelled'])->count(),
                'OpsPulse'    => $OpsPulse,
                'graphData'   => $graphData,

            ];
            
        }
        
        if (session()->has('team') && session()->get('team')->_id) {
            $teamId = new ObjectId(session()->get('team')->_id);
            $branchId = new ObjectId(session()->get('team')->branchId);
            
            $attendance = Attendance::where('teamId', $teamId)
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->first();

           if(session()->get('team')->department=='67bd3cd7d4de44c0093ea46d'){
            #Branch sub admin 
                
                $lead    = Lead::where('branch', $branchId)->whereNotNull('assign_to_sales')->get();
                $task    = AssignTask::get();
                $sales   = FollowUpLead::where('teamBranchId', $branchId)->get();
                
                $noOfLeadAssign = $sales->unique('leadId')->count();
                $converstionLead  = $sales->count();
                
                $lsr = $noOfLeadAssign > 0 ? $converstionLead / ($noOfLeadAssign * 100) : 0;
                
                $OpsPulse = [
                    'newTask'     => $task->where('taskStatus','Not Started')->count(),
                    'activeTask'  => $task->where('taskStatus','In Progress')->count(),
                    'pendingTask' => $task->whereIn('taskStatus',['Not Started','In Progress'])->count(),
                    'closedTask'  => $task->where('taskStatus','Completed')->count(),
                    'totalTask'   => $task->count()
               ];
        
               $newLead = $lead->whereNull('projectStatus')
                            ->count();

               $activeLead = $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress'])->count();
    
                $dashboard = [
                    'newLead'     => $newLead,
                    'activeLead'  => $activeLead,
                    'closeLead'   => $lead->where('projectStatus', 'Completed')->count(),
                    'pendingLead' => $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress','Pending'])->count()+$newLead,
                    'totalLead'   => $lead->count(),
                    'lsr'         => $lsr,
                    'salseClose'  => $lead->whereIn('projectStatus', ['Not Reachable','Not Interested','Cancelled'])->count(),
                    'OpsPulse'    => $OpsPulse,
                    'graphData'   => $graphData,
    
                ];
           }
           #hr manager and sub admin
            if(session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->get('team')->department=='67bd6d68d4de44c0093ea46f'){
                $teamData = Team::where('branchId', new ObjectId(session()->get('team')->branchId))->get();
                $today = Carbon::now();

                $newHire = NewHiresModel::where('branchId', new ObjectId(session()->get('team')->branchId))->count();
                $regignationEmp = EmployeeRecognition::where('branchId', new ObjectId(session()->get('team')->branchId))->count();
                $employeeRetentionRate = $regignationEmp > 0 ? ($newHire / $regignationEmp) * 100 : 0;
                

                $dashboard = [
                        'EmployeeRetentionRate' => $employeeRetentionRate,
                        'ActiveEmployee'        => $teamData->where('status','1')->count(),
                        'ResignationEmployee'   => $regignationEmp,
                        'TotalEmployee'         => $teamData->count(),
                        'birthdayEmp'           => Team::where('branchId', new ObjectId(session()->get('team')->branchId))
                                                    ->whereRaw([
                                                        '$expr' => [
                                                            '$and' => [
                                                                ['$eq' => [['$substr' => ['$dateOfBirth', 5, 2]], sprintf('%02d', $today->month)]],  // Match current month
                                                                ['$gte' => [['$substr' => ['$dateOfBirth', 8, 2]], sprintf('%02d', $today->day)]]   // Upcoming days only
                                                            ]
                                                        ]
                                                    ])
                                                    ->orderBy('dateOfBirth', 'asc')   
                                                    ->get()
                                                ];
                    
                    
            }
            #Salse Manager and sub salse
            if(session()->get('team')->department=='6790b8962ef8f2064c61d076'){
                $team_id = new ObjectId(session()->get('team')->_id);

                $lead    = Lead::when($team_id, function ($query) use ($team_id) {
                                if(session()->get('team')->designation == new ObjectId('6790b9662ef8f2064c61d07e')){    ///slase manager
                                    
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
                                
                            })->whereNotNull('assign_to_sales')->get();
                

                $sales   = FollowUpLead::where('teamBranchId', $branchId)
                            ->where('teamId', $team_id)->get();
                
                $noOfLeadAssign = $sales->unique('leadId')->count();
                $converstionLead  = $sales->count();
                
                $lsr = $noOfLeadAssign > 0 ? $converstionLead / ($noOfLeadAssign * 100) : 0;
                
                $OpsPulse = [];
        
                $newLead = $lead->whereNull('projectStatus')
                            ->count();

               $activeLead = $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress'])->count();
    
                $dashboard = [
                    'newLead'     => $newLead,
                    'activeLead'  => $activeLead,
                    'closeLead'   => $lead->where('projectStatus', 'Completed')->count(),
                    'pendingLead' => $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress','Pending'])->count()+$newLead,
                    'totalLead'   => $lead->count(),
                    'lsr'         => $lsr,
                    'salseClose'  => $lead->whereIn('projectStatus', ['Not Reachable','Not Interested','Cancelled'])->count(),
                    'OpsPulse'    => $OpsPulse,
                    'graphData'   => $graphData,
    
                ];
            }
            #operation
            if(session()->get('team')->department=='6790b8b82ef8f2064c61d077'){
                $teamId = session()->get('team')->_id;
                $clientId = Client::when(!empty($teamId), function($query) use($teamId){
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

                $task = AssignTask::whereIn('clientId', $clientId)->get();
                $taskReply = AssignTaskReplay::where('assignByTeamId', $teamId)->get();
                
                

                // Assign to graph variable
               $activeTask = $taskReply->unique('clientId')->whereNotIn('taskStatus',['Completed'])->count();;
              
    
               $OpsPulse = [
                            'newTask'     => $task->where('taskStatus','Not Started')->count(),
                            'activeTask'  => $task->where('taskStatus','In Progress')->count(),
                            'pendingTask' => $task->whereIn('taskStatus',['Not Started','In Progress'])->count(),
                            'closedTask'  => $task->where('taskStatus','Completed')->count(),
                            'totalTask'   => $task->count()
                    ];
    
                $dashboard = [
                    'newLead'     => '',
                    'activeLead'  => '',
                    'closeLead'   => '',
                    'pendingLead' => '',
                    'totalLead'   => '',
                    'lsr'         => '',
                    'salseClose'  => '',
                    'OpsPulse'    => $OpsPulse,
                    'graphData'   => $graphData,
    
                ];
            }
           
        }

        if (session()->has('branch') && session()->get('branch')->_id) {
            $branchId = new ObjectId(session()->get('branch')->_id);
            
            $clientId = Client::when(!empty($branchId), function($query) use($branchId){
                $query->where("branchId",new ObjectId($branchId));
            })
            
                ->pluck('_id')
                ->map(fn($id) => new ObjectId($id)) // Ensure all IDs are ObjectId instances
                ->toArray();

            $task = AssignTask::whereIn('clientId', $clientId)->get();
            
            $attendance = Attendance::where('branchId', $branchId)
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->first();
            
                $lead    = Lead::where('branch', $branchId)->whereNotNull('assign_to_sales')->get();
                $sales   = FollowUpLead::where('teamBranchId', $branchId)->get();
                
               $noOfLeadAssign = $sales->unique('leadId')->count();
               $converstionLead  = $sales->count();
    
               $lsr = $noOfLeadAssign > 0 ? $converstionLead / ($noOfLeadAssign * 100) : 0;
              
               $OpsPulse = [
                        'newTask'     => $task->where('taskStatus','Not Started')->count(),
                        'activeTask'  => $task->where('taskStatus','In Progress')->count(),
                        'pendingTask' => $task->whereIn('taskStatus',['Not Started','In Progress'])->count(),
                        'closedTask'  => $task->where('taskStatus','Completed')->count(),
                        'totalTask'   => $task->count()
                ];
                
                $newLead = $lead->whereNull('projectStatus')
                            ->count();

                $activeLead = $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress'])->count();

                    $dashboard = [
                        'newLead'     => $newLead,
                        'activeLead'  => $activeLead,
                        'closeLead'   => $lead->where('projectStatus', 'Completed')->count(),
                        'pendingLead' => $lead->whereIn('projectStatus', ['Pitch In Progress','In Progress','Pending'])->count()+$newLead,
                        'totalLead'   => $lead->count(),
                        'lsr'         => $lsr,
                        'salseClose'  => $lead->whereIn('projectStatus', ['Not Reachable','Not Interested','Cancelled'])->count(),
                        'OpsPulse'    => $OpsPulse,
                        'graphData'   => $graphData,

                    ];
                    
           
        }
       
        return view('admin.dashboard', compact('attendance','dashboard'));
    }
    public function fetchTeam(Request $req){
        $team = Team::with('department1', 'designation1')
                ->where('_id', new ObjectId($req->teamId))
                ->first();
                
        if ($team) {
            $data = [
                'departmentName'  => !empty($team->department1) ? $team->department1->name : '',
                'designationName' => !empty($team->designation1) ? $team->designation1->name : '',
                'email'           => $team->email,
            ];
        } else {
            $data = [];
        }  
        

        return response()->json($data);
    }
}
