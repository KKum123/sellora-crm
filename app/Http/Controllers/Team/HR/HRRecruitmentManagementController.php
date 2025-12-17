<?php

namespace App\Http\Controllers\Team\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\CondidateRequest;
use App\Models\ERP\CondidateInfo;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class HRRecruitmentManagementController extends Controller
{
    public function candidateInfo(Request $req){

        return view("team.hr.recruitment-management.candidate-info");
    }
    public function saveCandidateInfo(CondidateRequest $req){
         $hrId = session()->get('team')->_id;
         $inputArr = $req->except('_token');
         $inputArr['hrId'] = $hrId;

         if($req->id){
            CondidateInfo::where('_id', new ObjectId($req->id))->update($inputArr);
            return redirect(route('team.recruitmentManagement.interviewStatus'))->with('success','Updated added successfully');
        }else{
            CondidateInfo::create($inputArr);
            return redirect()->back()->with('success','Condidate added successfully');
         }
    }
    public function interviewStatus(Request $req){
        $hrId = session()->get('team')->_id;
        $List = CondidateInfo::when($req->candidateName, function($query) use($req){
            $query->where('candidateName','like','%'.$req->candidateName.'%');
        })
        ->when($req->jobProfile, function($query) use($req){
            $query->where('jobProfile','like','%'.$req->jobProfile.'%');
        })
        ->when($req->interviewStatus, function($query) use($req){
            $query->where('interviewStatus','like','%'.$req->interviewStatus.'%');
        })
        ->paginate(20);

        return view("team.hr.recruitment-management.interview-status", compact('List'));
    }
    public function getInterviewStatus($id){
        $singleData =  CondidateInfo::where('_id', new ObjectId($id))->first();
        return view("team.hr.recruitment-management.candidate-info", compact('singleData'));
    }
    public function changeInterviewStatus(Request $req){
        $teamId = session()->get('team')->_id;
        CondidateInfo::where('_id', operator: new ObjectId($req->id))->update([
            'interviewStatus' =>$req->interviewStatus,
            'chnageStatuByHrId'=> new ObjectId($teamId)
        ]);
        return back()->with(['success', 'Status updated successfully']);
    }
}
