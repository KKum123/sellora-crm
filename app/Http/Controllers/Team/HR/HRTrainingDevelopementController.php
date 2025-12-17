<?php

namespace App\Http\Controllers\Team\HR;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\HireRequest;
use App\Http\Requests\LMSRequest;
use App\Models\ERP\HRTrainingModel;
use App\Models\ERP\NewHiresModel;
use App\Models\ERP\Team;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use function PHPUnit\Framework\returnArgument;

class HRTrainingDevelopementController extends Controller
{
    public function lms(Request $req){
        $branchId = session()->get('team')->branchId;
        $singleData  = '';//HRTrainingModel::where('branchId', new ObjectId($branchId))->first();
        $List = HRTrainingModel::where('branchId', new ObjectId($branchId))->paginate(20);
        
        return view("team.hr.training-and-developement.lms", compact('singleData','List'));
    }
    
    public function newHires(Request $req){
        $branchId = session()->get('team')->branchId;
        $newHires = NewHiresModel::where('branchId', new ObjectId($branchId))
                    ->pluck('teamId') 
                    ->map(function($teamId) {
                        return new ObjectId($teamId); 
                    })->toArray();
                 
         $teamList = Team::with('department1', 'designation1')
                    ->whereNotIn('_id', $newHires) 
                    ->where([
                        'branchId' => new ObjectId($branchId),
                        'status' => '1',
                    ])
                    ->get();
                     
        $List = NewHiresModel::with('hr','team')->where('branchId', new ObjectId($branchId))->latest()->paginate(20);
        
        return view("team.hr.training-and-developement.new-hires", compact('teamList','List'));
    }
    public function saveNewHires(HireRequest $req){
        
        $hrData = session()->get('team');
        $data = new NewHiresModel();
        $data->teamId = new ObjectId($req->teamId);
        $data->hrId   = new ObjectId($hrData->_id);
        $data->branchId = new ObjectId($hrData->branchId);
        $data->save();

        return redirect()->back()->with('success','New Hires added successfully.');
        
    }
    public function deleteNewHires($id){
        NewHiresModel::where('_id', new ObjectId($id))->delete();
        return back()->with('success','Deleted successfully');
    }
    public function lmsSave(LMSRequest $req){
        $inputArr = $req->except('_tone');
        $inputArr['hrId'] = new ObjectId(session()->get('team')->_id);
        $inputArr['branchId'] = new ObjectId(session()->get('team')->branchId);
        $inputArr['status'] = isset($req->status) ? 1 : 0;

        if($req->id){
            $update = HRTrainingModel::find(new ObjectId($req->id));
            if($req->hasFile(key: 'uploadPDF')){
                $dir = 'LMS/uploadPDF';
                $inputArr['uploadPDF'] = Helpers::uploadFile($dir, $req->uploadPDF);
                @unlink(public_path($update->uploadPDF));
            }else{
                $inputArr['uploadPDF'] = $update->uploadPDF;
            }
            if($req->hasFile('uploadImage')){
                $dir = 'LMS/uploadImage';
                $inputArr['uploadImage'] = Helpers::uploadFile($dir, $req->uploadImage);
                @unlink(public_path($update->uploadImage));
            }else{
                $inputArr['uploadImage'] = $update->uploadImage;
            }
            
            $update->update($inputArr);

            return redirect(route('team.trainingDevelopment.lms'))->with('success','Updated successfully');
        }else{
            if($req->hasFile('uploadPDF')){
                $dir = 'LMS/uploadPDF';
                $inputArr['uploadPDF'] = Helpers::uploadFile($dir, $req->uploadPDF);
            }
            if($req->hasFile('uploadImage')){
                $dir = 'LMS/uploadImage';
                $inputArr['uploadImage'] = Helpers::uploadFile($dir, $req->uploadImage);
            }
            
            HRTrainingModel::create($inputArr);

            return redirect(route('team.trainingDevelopment.lms'))->with('success','Created successfully');
        }
        
    }
    public function lmsGet($id){
        $singleData  = HRTrainingModel::where('_id', new ObjectId($id))->first();
        return view("team.hr.training-and-developement.lms", compact('singleData'));
   
    }
    public function lmsDelete($id){
        $singleData  = HRTrainingModel::where('_id', new ObjectId($id))->first();
        @unlink(public_path($singleData->uploadPDF));
        @unlink(public_path($singleData->uploadImage));
         HRTrainingModel::where('_id', new ObjectId($id))->delete();
        return back()->with('success', 'Deleted Successfully');

    }
}
