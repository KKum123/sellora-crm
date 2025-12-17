<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\ERP\Attendance;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class AdminAttendanceControllers extends Controller
{
    public function goodMorningAttendance(AttendanceRequest $req){
        $existBranchId = null;
        $teamId = null;
        $branchId = null;
        $adminId = null;
        
        if(session()->has('admin')){
           $adminId =  session()->has('admin')  ? new ObjectId(session()->get(key: 'admin')->_id): null;
           $existBranchId = session()->has('admin')  ? new ObjectId(session()->get(key: 'admin')->branchId): null;
        }
        if(session()->has('team')){
            $teamId =  session()->has('team')  ? new ObjectId(session()->get(key: 'team')->_id): null;
            $existBranchId = session()->has('team')  ? new ObjectId(session()->get(key: 'team')->branchId): null;
        }
        if(session()->has('branch')){
            $branchId =  session()->has('branch')  ? new ObjectId(session()->get(key: 'branch')->_id): null;
            $existBranchId = session()->has('branch')  ? new ObjectId(session()->get(key: 'branch')->_id): null;
        }

        $userIp = $req->header('X-Forwarded-For') ?? $req->ip();

        if($req->attendanceId){
            $data = [
                'goodNightDateTime'  => date('Y-m-d H:i:s'),
                'goodNightMessage'   => $req->goodNightMessage ?? null,
                'userIpGoodNight'    => $userIp
            ];
            if(session()->has('team')){
                Attendance::where('teamId', $teamId)
                ->where('_id', new ObjectId($req->attendanceId))->update($data);
            }
            if(session()->has('admin')){
                Attendance::where('adminId', $adminId)
                ->where('_id', new ObjectId($req->attendanceId))->update($data);
            }
            if(session()->has('branch')){
                Attendance::where('branchId', $branchId)
                ->where('_id', new ObjectId($req->attendanceId))->update($data);
            }
        }else{
          
            $data = [
                'adminId'       => $adminId,
                'branchId'      => $branchId,
                'teamId'        => $teamId,
                'existBranchId'      => $existBranchId,
                'goodMoringDateTime' => date('Y-m-d H:i:s'),
                'goodNightDateTime'  => null,
                'goodNightMessage'   => null,
                'updateByHrId'       => null,
                'hrRemarks'          => null,
                'correctionDateTime' => null,
                'userIpGoodNight'    => null,
                'userIpGoodMorning'  => $userIp
            ];
            
            Attendance::create($data);
        }
        
       return back()->with('success','Attendance record added successfully');
    }
    
    public function attendanceReport(Request $req){
        $teamId = session()->get('team')->_id;
        // Determine date range
        if (!empty($req->filterBtn) && $req->filterBtn == 'Last Month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
        } else {
            // Default to current month
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        $attendance = Attendance::where('teamId', new ObjectId($teamId))
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->orderBy('created_at','desc')
                     ->get();
                     
        return view('team.hr.payroll.attendance-current-last', compact('attendance'));
    }
}
