<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyAdminBranchRequest;
use App\Http\Requests\TaskRequest;
use App\Models\ERP\Team;
use App\Models\ReplyTaskAdminBaranch;
use App\Models\TaskAdminBranch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Expr\FuncCall;
use MongoDB\BSON\ObjectId;

class TaskControllers extends Controller
{
    public function addTask(Request $req){
        $adminId  = session()->has('admin') ? session()->get('admin')->_id : "";
        $branchId = session()->has('branch') ? session()->get('branch')->_id : "";

        $teamList = Team::where("status", "1")
                    ->when($adminId, function($query) use($adminId){
                    //    sub admin
                        $query->where('designation', new ObjectId('67bd3bbfd4de44c0093ea46a'));
                    })
                    ->when($branchId, function($query) use($branchId){
                    // sub branch
                        $query->where('designation', new ObjectId('67bd3bd9d4de44c0093ea46b'))
                                ->where('branchId', new ObjectId($branchId));
                    })
                     ->get();

        return view('branch.task.add-task', compact('teamList'));
    }
    public function saveTaskSubmit(TaskRequest $req){
        $adminId = null;
        $branchId = null;
        
        if(session()->has('admin')){
            $adminId = session()->get('admin')->_id;
            $taskRole = 'Admin';
            
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
            $taskRole = 'Branch';
        }
       
        if($req->isMethod('post')){
            $task = new TaskAdminBranch;
            $task->teamId    = new ObjectId($req->teamId);
            $task->taskTitle = $req->taskTitle;
            $task->taskDetails = $req->taskDetails;
            $task->completionTime = $req->completionTime;
            $task->taskRole    = $taskRole;
            $task->branchId    = !empty($branchId) ?  new ObjectId($branchId) : null;
            $task->adminId     = !empty($adminId) ?  new ObjectId($adminId) : null;
            $task->save();

            return back()->with('success', 'Task Added');
        }
       
    }
    public function listTask(Request $req){
        $adminId = null;
        $branchId = null;
        
        if(session()->has('admin')){
            $adminId = session()->get('admin')->_id;
            $taskRole = 'Admin';
            
        }
        if(session()->has('branch')){
            $branchId = session()->get('branch')->_id;
            $taskRole = 'Branch';
        }

        $List = TaskAdminBranch::latest()
                ->when($req->fromDate && $req->toDate, function($query) use($req){
                    $query->whereBetween('created_at', 
                            [
                                Carbon::parse($req->fromDate)->startOfDay(), 
                                Carbon::parse($req->toDate)->endOfDay()
                                ]
                        );
                })
                ->when($req->teamId, function($query) use($req){
                    $query->where('teamId', new ObjectId($req->teamId));
                })
                ->when($adminId, function($query) use($adminId){
                    $query->where('adminId', new ObjectId($adminId))
                        ->where('taskRole', 'Admin');
                })->when($branchId, function($query) use($branchId){
                    $query->where('branchId', new ObjectId($branchId))
                        ->where('taskRole', 'Branch', );
                })->paginate(10);
        
        $teamList = Team::where("status", "1")
                ->when($adminId, function($query) use($adminId){
                //    sub admin
                    $query->where('designation', new ObjectId('67bd3bbfd4de44c0093ea46a'));
                })
                ->when($branchId, function($query) use($branchId){
                // sub branch
                    $query->where('designation', new ObjectId('67bd3bd9d4de44c0093ea46b'))
                            ->where('branchId', new ObjectId($branchId));
                })
                 ->get();
                
        return view('branch.task.list-task', compact('List','teamList'));
    }
    public function listTaskUpdate($id){
        $adminId  = session()->has('admin') ? session()->get('admin')->_id : "";
        $branchId = session()->has('branch') ? session()->get('branch')->_id : "";
        $singleData = TaskAdminBranch::where('_id', new ObjectId($id))->first();

        $teamList = Team::where("status", "1")
                    ->when($adminId, function($query) use($adminId){
                    //    sub admin
                        $query->where('designation', new ObjectId('67bd3bbfd4de44c0093ea46a'));
                    })
                    ->when($branchId, function($query) use($branchId){
                    // sub branch
                        $query->where('designation', new ObjectId('67bd3bd9d4de44c0093ea46b'))
                                ->where('branchId', new ObjectId($branchId));
                    })
                     ->get();
            
        return view('branch.task.add-task', compact('teamList'));
    }
    public function listTaskDelete($id){
        TaskAdminBranch::where('_id', new ObjectId($id))->delete();
        return back()->with('success', 'Deleted Successfully');
    }
    public function replyView($id){
        $singleData = TaskAdminBranch::where('_id', new ObjectId($id))->first();

        $List = ReplyTaskAdminBaranch::where('taskId', new ObjectId($id))
                    ->orderBy('created_at','desc')
                    ->paginate(10);
        return view('branch.task.reply-view', compact('List','singleData'));
    }
    public function viewTaskAdminBranch(Request $req){
        $branchId = session()->has('team') ? session()->get('team')->_id : '';
        $List = TaskAdminBranch::when($branchId, function($query) use($branchId){
            $query->where('teamId', new ObjectId($branchId));
        })
        
        ->when($req->fromDate && $req->toDate, function($query) use($req){
            $query->whereBetween('created_at', 
                       [
                           Carbon::parse($req->fromDate)->startOfDay(), 
                           Carbon::parse($req->toDate)->endOfDay()
                           ]
                   );
        })
        ->orderBy('updated_at','desc')
        ->paginate(10);

        return view('branch.task.reply.view-task-branch-admin', compact('List'));
    }
    public function replyTaskAdminBranch(ReplyAdminBranchRequest $req){
        
        $teamId = session()->has('team') ? session()->get('team')->_id : '';

        $replyTask = new ReplyTaskAdminBaranch;
        $replyTask->teamId = new ObjectId($teamId);
        $replyTask->taskStatus = $req->status;
        $replyTask->taskId = new ObjectId($req->taskId);
        $replyTask->timeSpend = $req->spentTime;
        $replyTask->taskReply = $req->remarks;
        $replyTask->adminId = !empty($req->adminId) ? new ObjectId($req->adminId) : null;
        $replyTask->brachId = !empty($req->branchId) ? new ObjectId($req->branchId) : null;
        
        $replyTask->save();

        TaskAdminBranch::where('_id', new ObjectId($req->taskId))->update(['taskStatus'=>$req->status]);
        return back()->with('success', 'Reply successfully');
    }
}
