<?php

namespace App\Http\Controllers\Team\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExitIntRequest;
use App\Models\ERP\ExitInterviewModels;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Regex;

use Carbon\Carbon;

class HREmployeeManagementController extends Controller
{
    public function exEmployee(Request $req){
        $branchId = session()->get('team')->branchId;
        
        $employeeIds = Team::where('branchId', new ObjectId($branchId))
            ->when($req->name, function ($query) use ($req) {
                $query->where('name', 'like', '%' . $req->name . '%');
            })
            ->when($req->email, function ($query) use ($req) {
                $query->where('email', $req->email);
            })
            ->when($req->phone, function ($query) use ($req) {
                $query->where('mobile', $req->phone);
            })
            ->pluck('_id')
            ->map(fn($id) => new ObjectId($id))
            ->toArray();

        $exEmployee = ExitInterviewModels::whereIn('employeeId', $employeeIds)
                ->with(['employee', 'departments', 'designations']) // Load relations
                ->orderBy('_id', 'desc')
                ->paginate(20);
       
       
        
        return view('team.hr.employee-management.ex-employee', compact('exEmployee'));

    }
    public function exitInterview(Request $req){
        $branchId = session()->get('team')->branchId;
        $exEmolyeeId = ExitInterviewModels::with(['emplyee'=>function($query) use($branchId){
                        $query->where('branchId', new ObjectId($branchId));
                    }])
                 ->pluck('employeeId')->toArray();
       
        $employee = Team::with('department1','designation1')
                    ->whereNotIn('_id', $exEmolyeeId)
                    ->where( 'branchId',new ObjectId($branchId))
                    ->where('status', '1')
                    ->orderBy('name','asc')
                    ->get();
       
        return view('team.hr.employee-management.exit-interview', compact('employee'));
    }
    public function saveExitInterview(ExitIntRequest $req){ 
        $hrId = session()->get('team')->_id;
        
        $inputArr = $req->except('_token');
        $inputArr['hrId'] = new ObjectId($hrId);

        $inputArr['departmentId']  = new ObjectId($req->departmentId);
        $inputArr['designationId'] = new ObjectId($req->designationId);
        $inputArr['employeeId']    = new ObjectId($req->employeeId);

        ExitInterviewModels::create($inputArr);

        return redirect()->back()->with('success','Exit employee added successfully.');
    }
}
