<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ERP\Branch;
use App\Models\ERP\Designation;
use App\Models\ERP\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\ObjectId;

class AdminSubAdminControllers extends Controller
{
    public function index(Request $req){
        if($req->isMethod('post')){
            $this->validate($req, [
                'name'     => 'required',
                'email'    => "unique:users,email,$req->id,id",
            ]);

            $inputArr = $req->except('_token');
            $inputArr['password'] = Hash::make($req->password);
            $inputArr['show_password'] =base64_encode($req->password);
            $inputArr['role'] = 'Sub Admin';
            $inputArr['branchId'] = new ObjectId($req->branchId);
            $inputArr['status'] = isset($req->status) ? $req->status : 0;

            if($req->id){
                User::where('_id', $req->id)->update($inputArr);
            }else{
                $lastNumber = User::max('employeeIdCode');
                $newNumber = str_pad((int)substr($lastNumber, 3) + 1, 4, '0', STR_PAD_LEFT);
                $inputArr['employeeIdCode'] = 'SRL0' . $newNumber;

                User::create($inputArr);
            }
            return redirect(route('admin.subadmin.list'))->with('success','Successfully');
        }
       
        $branch  = Branch::where('status',"1")->orderBy('branch_name','asc')->get();
        
        return view('admin.add-sub-admin', compact('branch'));
    }
    public function list(){
        $List = User::with('branch')->latest()->where('role','Sub Admin')->paginate(20);
  
        return view('admin.sub-admin-list', compact('List'));

    }
    public function getSubAdminUpdate($id){
        $branch  = Branch::where('status',"1")->orderBy('branch_name','asc')->get();
        
        $singleData = User::find($id);
        return view('admin.add-sub-admin', compact('singleData','branch'));
    }
    public function checkMail(Request $req){
        $exists = User::where('email', $req->email)->exists();
    
        return response()->json(['exists' => $exists]);
    }
    public function checkBranchMail(Request $req){
        $exists = Branch::where('email', $req->email)->exists();
    
        return response()->json(['exists' => $exists]);
    }
    public function getSubAdminDelete ($id){
   
        User::where('_id', $id)->delete();
        return back()->with('success','Delete Successfully');
    }
    public function checkTeamMail (Request $req){
   
        $exists = Team::where('email', $req->email)->exists();
    
        return response()->json(['exists' => $exists]);
    }
    public function getDesignation(Request $req){
        $data = Designation::where(column: 'departmentId',operator: $req->departmentId)->get();
        $html = "<option value=''>Select</option>";
        foreach ($data as $key => $value) {
            $html .= "<option value='".$value->_id."'>".$value->name."</option>";
        }   
        $htmlData = "<select  class='form-select' name='designation' id='designationId' required>
              $html
        </select>";
        return response()->json(["html"=> $htmlData]);

    }
    public function getBranch(Request $req){
        $data = Branch::where( 'country', $req->country)->where('status',"1")->get();
        $html = "<option value=''>Select</option>";
        foreach ($data as $key => $value) {
            $html .= "<option value='".$value->_id."'>".$value->branch_name."</option>";
        }   
        $htmlData = "<select  class='form-select' name='branch' id='branch' onchange='branchChange()' required>
              $html
        </select>";
        return response()->json(["html"=> $htmlData]);
    }
    public function getBranch1(Request $req){
        $data = Branch::where( 'country', $req->country)->where('status',"1")->get();
        $html = "<option value=''>Select</option>";
        foreach ($data as $key => $value) {
            $html .= "<option value='".$value->_id."'>".$value->branch_name."</option>";
        }   
        $htmlData = "<select  class='form-select' name='branchId' id='branch' onchange='branchChange()' required>
              $html
        </select>";
        return response()->json(["html"=> $htmlData]);
    }
    public function OperationalManagerUsingBranch(Request $req){
        $data = Team::where( 'branchId', new ObjectId($req->branchId)) 
                ->where('designation', new ObjectId('6797015d1af1e9898db5951d')) //Operation Manager 
                ->where('status',"1")
                ->get();
       
        $html = "<option value=''>Select</option>";
        foreach ($data as $key => $value) {
            $html .= "<option value='".$value->_id."'>".$value->name."</option>";
        }   
        $htmlData = "<select  class='form-select' name='assignAdminByOperationManager' id='assignAdminByOperationManager' required>
              $html
        </select>";
        return response()->json(["html"=> $htmlData]);
    }
    public function getSalesTeamBranch(Request $req){
        $data = Team::where( 'branchId', new ObjectId($req->branchId)) 
                    ->where('department', new ObjectId('6790b8962ef8f2064c61d076')) //salse 
                    ->where('status',"1")
                    ->get();
       
        $html = "<option value=''>Select</option>";
        foreach ($data as $key => $value) {
            $html .= "<option value='".$value->_id."'>".$value->name."</option>";
        }   
        $htmlData = "<select  class='form-select' name='assign_to_sales' id='assign_to_sales' required>
              $html
        </select>";

        return response()->json(["html"=> $htmlData]);
    }
}
