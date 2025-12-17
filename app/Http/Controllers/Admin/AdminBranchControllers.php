<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\ERP\Branch;
use App\Models\ERP\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\ObjectId;

class AdminBranchControllers extends Controller
{
    public function addBranch(Request $req){
        $country = Country::get();
        return view('admin.branch.add-branch', compact('country'));
    }
    public function addSaveBranch(BranchRequest $req){
    
        $inputArr = $req->except('_token');
        $inputArr['show_password'] = base64_encode($req->password);
        $inputArr['password'] = Hash::make($req->password);
        $inputArr['status'] = isset($req->status) ? $req->status : 0;
       
        if($req->id){
            
            Branch::where('_id',$req->id)->update($inputArr);
            $message = "Created successfully";
        }else{
            
            $inputArr['admin_id'] = session()->get('admin')->id;
            if(session()->has('branch')){
                $inputArr['role'] = 'Sub Branch';
            }
            if(session()->has('admin')){
                $inputArr['role'] = 'Branch';
            }
            Branch::create($inputArr);
            $message = "Updated successfully";
        }
        return redirect(route('admin.branch.viewBranch'))->with('success', $message);
    }
    public function viewBranch(Request $req){
        $branchId = null;
        if(session()->has('branch')){
            $branchId = new ObjectId(session()->get('branch')->_id);
        }
        $List =  Branch::when($req->branch_name, function($query) use($req){
            return $query->where('branch_name', 'like', '%' . $req->branch_name);
        })
        ->when($req->country, function($query) use($req){
            return $query->where('country', $req->country);
        })
        ->when($branchId, function ($query) use($branchId){
            return $query->where('branchId', $branchId);
        })
        ->latest()->paginate();
        $country = Country::latest()->get();
        return view('admin.branch.view-branch', compact('List','country'));
    }
    public function updateBranch($id){
        $singleData = Branch::find($id);
        $country = Country::get();
        return view('admin.branch.add-branch', compact('country','singleData'));
    }   
    public function deleteBranch($id){
        Branch::where('_id',$id)->delete();
        return redirect()->back()->with('success', 'Branch deleted successfully');
    }
}
