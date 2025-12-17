<?php

namespace App\Http\Controllers\Team\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\BonusesAndIncentiveRequest;
use App\Http\Requests\LeaveRequest;
use App\Models\ERP\Attendance;
use App\Models\ERP\BonusesIncentives;
use App\Models\ERP\Department;
use App\Models\ERP\Leave;
use App\Models\ERP\LeaveList;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use DateTime;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class HRPayrollController extends Controller
{
    public function attendance(Request $req){
        $branchId = session()->get("team")->branchId;
        $employee = Team::where('branchId', new ObjectId($branchId))->where('status', '1')->get();
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        return view("team.hr.payroll.attendance", compact('employee','months'));
    }
    public function employeeSalary(Request $req){
        $branchId = session()->get("team")->branchId;

        $List = Team::with('department1','designation1')
                ->where('branchId', new ObjectId($branchId))
                ->when($req->name, function($query) use($req){
                    $query->where('name','like','%'.$req->name.'%');
                })
                ->when($req->department, function($query) use($req){
                    $query->where('department', new ObjectId($req->department));
                })
                ->when($req->from_date && $req->to_date, function($query) use($req){
                    return $query->whereBetween('joinDate', 
                       [
                           Carbon::parse($req->from_date)->startOfDay(), 
                           Carbon::parse($req->to_date)->endOfDay()
                           ]
                       );
                })
                ->where('status','1')->latest()->paginate(20);

                $department = Department::get();
        return view("team.hr.payroll.employee-salary", compact('List','department'));
    }
    public function bonusesAndIncentives(Request $req){
        $branchId = session()->get("team")->branchId;
        $employee = Team::with('department1','designation1')
                        ->where(['branchId'=> new ObjectId($branchId), 'status'=>'1'])->get();
        $List = BonusesIncentives::where('branchId', new ObjectId($branchId))
                ->latest()
                ->paginate(20);
       

        return view("team.hr.payroll.bonuses-incentives", compact('List','employee'));
    }
    public function bonusesAndIncentivesSave(BonusesAndIncentiveRequest $req){
        $branchId = session()->get("team")->branchId;
        $hrId     = session()->get("team")->_id;

        $inputArr = $req->except('_token');
        $inputArr['hrId'] = new ObjectId($hrId);
        $inputArr['branchId'] = new ObjectId($branchId);
        $inputArr['employeeId'] = new ObjectId($req->employeeId);
        BonusesIncentives::create($inputArr);
        return back()->with('success','Bonuses Incentives Added Successfully');
    }
    public function getCalander(Request $req){
        $customHolidaysJson = '';
        $month = isset($req->month) ? $req->month : date('m');
        $year  = isset($req->year) ? $req->year : date('Y');
        $totalLeave = 0;
        $singleData = Team::select('_id','name','employeeIdCode','employeeCode','attendance')->where('_id', new ObjectId($req->employeeId))->first();
      
        if($singleData){
            $attendance = Attendance::where('teamId',new ObjectId($req->employeeId))
                            ->whereRaw([
                                '$expr' => [
                                    '$and' => [
                                        [
                                            '$eq' => [
                                                ['$month' => [
                                                    '$dateFromString' => [
                                                        'dateString' => '$goodNightDateTime',
                                                        'format' => "%Y-%m-%d %H:%M:%S"
                                                    ]
                                                ]],
                                                (int) $month
                                            ]
                                        ],
                                        [
                                            '$eq' => [
                                                ['$year' => [
                                                    '$dateFromString' => [
                                                        'dateString' => '$goodNightDateTime',
                                                        'format' => "%Y-%m-%d %H:%M:%S"
                                                    ]
                                                ]],
                                                (int) $year
                                            ]
                                        ]
                                    ]
                                ]
                            ])
                            ->get();
            $leave = LeaveList::where('leaveStatus','Approved')->where('employeeId',new ObjectId($req->employeeId))
                    ->whereRaw([
                        '$expr' => [
                            '$and' => [
                                [
                                    '$eq' => [
                                        ['$month' => [
                                            '$dateFromString' => [
                                                'dateString' => '$leaveDate',
                                                'format' => "%Y-%m-%d"
                                            ]
                                        ]],
                                        (int) $month
                                    ]
                                ],
                                [
                                    '$eq' => [
                                        ['$year' => [
                                            '$dateFromString' => [
                                                'dateString' => '$leaveDate',
                                                'format' => "%Y-%m-%d"
                                            ]
                                        ]],
                                        (int) $year
                                    ]
                                ]
                            ]
                        ]
                    ])
                    ->get();
            $totalLeave = $leave->count();

                           $customHolidays = [];
                            foreach ($attendance as $val) {
                                $date = \Carbon\Carbon::parse($val->goodMoringDateTime);
                                $day = (int) $date->format('j'); // Get day without leading zero
                                $monthFormatted = (int) $month; // Convert month to integer to remove leading zero
                                
                                $customHolidays["$monthFormatted-$day"] = [
                                    'name' => 'Present',
                                    'class' => 'bg-success',
                                    'color' => 'green'
                                ];
                            }

                            foreach($leave as $key =>  $val){
                                $date = \Carbon\Carbon::parse($val->leaveDate);
                                $day = (int) $date->format('j'); // Get day without leading zero
                                $monthFormatted = (int) $month; // Convert month to integer to remove leading zero
                                
                                $customHolidays["$monthFormatted-$day"] = [
                                    'name' => 'Leave',
                                    'class' => 'bg-danger',
                                    'color' => 'red'
                                ]; 
                            }

                            $customHolidaysJson = !empty($customHolidays) ? json_encode($customHolidays) : [];
        }
     
        
        $html = view('team.hr.payroll.calander', compact('singleData','month','year','customHolidaysJson','totalLeave'))->render();
        return response()->json(['html' => $html]);
    }

    public function leaveManagement(Request $req){
        $branchId = session()->get("team")->branchId;
        $employee = Team::where('branchId', new ObjectId($branchId))->where('status', '1')->get();
        
        $leaveList = Leave::with('employee')
                ->when($req->employeeId, function($query) use ($req){
                    $query->where('employeeId', new ObjectId($req->employeeId));
                })
                ->when($req->fromDate && $req->toDate, function($query) use ($req){
                    $query->whereIn('fromDate', [
                        Carbon::parse($req->fromDate)->startOfDay(), 
                        Carbon::parse($req->toDate)->endOfDay()
                    ]);
                })
                ->latest()->paginate(20);
        
        return view('team.hr.payroll.leave_management', compact('employee','leaveList'));
    }
    public function addLeave(LeaveRequest $req){
        
        $hrId = session()->get("team")->_id;
        $branchId = session()->get("team")->branchId;
        $inputArr = $req->except('_token');

        $inputArr['branchId']   = new ObjectId($branchId);
        $inputArr['hrId']       = new ObjectId($hrId);
        $inputArr['employeeId'] = new ObjectId($req->employeeId);
        $inputArr['applyDate']  = date('Y-m-d');

        $leave = Leave::create($inputArr);
       
        $fromDate = new DateTime($req->fromDate);
        $toDate = new DateTime($req->toDate);

        while ($fromDate <= $toDate) {
            $data = [
                'leaveId'    => new ObjectId($leave->_id),
                'hrId'       => new ObjectId($hrId),
                'employeeId' => new ObjectId($req->employeeId),
                'branchId'   => new ObjectId($branchId),
                'leaveDate'  => $fromDate->format('Y-m-d'), 
                'remarks'    => $req->remarks,
                'leaveStatus'=> $req->leaveStatus
            ];
          
            LeaveList::create($data);
        
            // Move to the next date
            $fromDate->modify('+1 day');
        }
        

        return back()->with('success', 'Leave applied successfully');
    }
}
