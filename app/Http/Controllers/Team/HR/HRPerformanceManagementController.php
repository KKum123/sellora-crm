<?php

namespace App\Http\Controllers\Team\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRecognitionRequest;
use App\Http\Requests\ExitIntRequest;
use App\Http\Requests\GoalSettingRequest;
use App\Models\ERP\EmployeeRecognition;
use App\Models\ERP\ExitInterviewModels;
use App\Models\ERP\GOalSetting;
use App\Models\ERP\PerformanceReview;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class HRPerformanceManagementController extends Controller
{
    public function goalSetting(Request $req){
        $branchId = session()->get('team')->branchId;
        $employeeId = '';
        
        if (
            session()->has('team') &&
            session()->get('team')->department != '6790b8df2ef8f2064c61d079' &&
            session()->get('team')->department != '67bd6d68d4de44c0093ea46f'
        ) {
            $employeeId = session()->get('team')->_id;
        }
       
        $employee = Team::with('department1','designation1','salesManage','operationManage')
                    ->where(['branchId'=> new ObjectId($branchId), 'status'=>'1'])->get();
  
        $List = GOalSetting::with('employee','manager')
                ->when($employeeId, function($query) use ($employeeId){
                    $query->where('employeeId', new ObjectId($employeeId));
                })
                ->where('branchId', new ObjectId($branchId))
                ->latest()
                ->paginate(20);
        
        return view("team.hr.performance-management.goal-setting", compact('employee','List'));
    }
    public function performanceReview(Request $req){
        $branchId = session()->get('team')->branchId;
        $employeeId = '';
        
        if (
            session()->has('team') &&
            session()->get('team')->department != '6790b8df2ef8f2064c61d079' &&
            session()->get('team')->department != '67bd6d68d4de44c0093ea46f'
        ) {
            $employeeId = session()->get('team')->_id;
        }

        $employee = Team::with('department1','designation1','salesManage','operationManage')
                    ->where(['branchId'=> new ObjectId($branchId), 'status'=>'1'])->get();
        
        $List = PerformanceReview::with('employee','manager')
                ->when($employeeId, function($query) use ($employeeId){
                    $query->where('employeeId', new ObjectId($employeeId));
                })
                ->where('branchId', new ObjectId($branchId))
                ->latest()->paginate(20);
        return view("team.hr.performance-management.performance-reviews", compact("employee","List"));
    }
    public function employeeRecognition(Request $req){
        $branchId = session()->get('team')->branchId;
        $employeeId = '';
        if (
            session()->has('team') &&
            session()->get('team')->department != '6790b8df2ef8f2064c61d079' &&
            session()->get('team')->department != '67bd6d68d4de44c0093ea46f'
        ) {
            $employeeId = session()->get('team')->_id;
        }

        $employee = Team::with('department1','designation1')
                    ->where(['branchId'=> new ObjectId($branchId), 'status'=>'1'])->get();

        $List = EmployeeRecognition::with('employee')
                    ->when($employeeId, function($query) use ($employeeId){
                        $query->where('employeeId', new ObjectId($employeeId));
                    })
                    ->where('branchId', new ObjectId($branchId))
                    ->latest()->paginate(20);      
                       
        return view("team.hr.performance-management.employee-recognition", compact('employee','List'));
    }
    
    public function saveGoalSetting(GoalSettingRequest $req)
    {
        $hrId = session()->get("team")->_id;
        $inputArr = $req->except('_token');
        $inputArr['hrId'] = new ObjectId($hrId);
        $inputArr['employeeId'] = new ObjectId($req->employeeId);
        $inputArr['departmentId'] = new ObjectId($req->departmentId);
        $inputArr['managerId'] = new ObjectId($req->managerId);
        $inputArr['branchId'] = new ObjectId(session()->get('team')->branchId);

        GOalSetting::create( $inputArr);
        return redirect()->back()->with('success','Goal created successfully');
    }
    public function savePerformanceReview(GoalSettingRequest $req){

        $hrId = session()->get('team')->_id;
        $inputArr = $req->except('_token');
        $inputArr['branchId'] = new ObjectId(session()->get('team')->branchId);
        $inputArr['employeeId'] = new ObjectId($req->employeeId);
        $inputArr['departmentId'] = new ObjectId($req->departmentId);
        $inputArr['managerId'] = new ObjectId($req->managerId);
        $inputArr['hrId'] = new ObjectId($hrId);
        
        PerformanceReview::create($inputArr);
        return back()->with('success','Performance addedd successfully');
    }
    public function saveEmployeeRecognition(EmployeeRecognitionRequest $req){
       
        $hrId = session()->get('team')->_id;
        $inputArr = $req->except('_token');
        $inputArr['employeeId'] = new ObjectId($req->employeeId);
        $inputArr['branchId'] = new ObjectId(session()->get('team')->branchId);
        $inputArr['hrId'] = new ObjectId($hrId);
        
        EmployeeRecognition::create($inputArr);
        return back()->with('success','Employee recognition addedd successfully');
    }
}