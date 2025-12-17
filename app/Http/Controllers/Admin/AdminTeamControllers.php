<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\ERP\Branch;
use App\Models\ERP\Client;
use App\Models\ERP\Country;
use App\Models\ERP\Department;
use App\Models\ERP\DepartmentPermission;
use App\Models\ERP\Designation;
use App\Models\ERP\Lead;
use App\Models\ERP\Menu;
use App\Models\ERP\MenuRoute;
use App\Models\ERP\TeamEducationInformations;
use App\Models\ERP\TeamExperience;
use App\Models\ERP\TeamFamilyInformations;
use App\Models\ERP\TeamPermission;
use App\Models\ERP\TeamProfile;
use Illuminate\Http\Request;
use App\Models\ERP\Team;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\ObjectId;

class AdminTeamControllers extends Controller
{
    public function addTeam(){
        $department = Department::get();
        $designation = Designation::get();
        $branch  = Branch::where('status',"1")->orderBy('branch_name','asc')->get();
        
        return view('admin.team.addTeam', compact('department','designation','branch'));
    }
    public function saveTeam(TeamRequest $req){
        
        $inputArr = $req->except('_token');
        if(!empty($req->password)){
            $inputArr['password'] = Hash::make($req->password);
            $inputArr['show_password'] = base64_encode($req->password);
        }
       
        if(empty($req->salary)){
          $inputArr['status'] = isset($req->status) ? $req->status : 0;
        }
        if($req->branchId){
            $inputArr['branchId'] = new ObjectId($req->branchId);
        }
        $inputArr['designation'] = new ObjectId($req->designation);
        $inputArr['department'] = new ObjectId($req->department);
        
        if(session()->has('admin')){
            $prefix = 'admin';
        }
        
        if(session()->has('team')){
            $prefix = 'team';
        }
        if(session()->has('branch')){
            $prefix = 'branch';
        }
        
        if($req->id){
            
           $update = Team::find( $req->id);
         
            if($req->hasFile('profileImage')){
                $dir = 'profile';
                $inputArr['profileImage'] = Helpers::imageResize($req->profileImage, $width = 250, $height = 300, $dir);
                @unlink(public_path($update->profileImage));
            }
            if(!empty($req->countryId)){
                $inputArr['countryId'] = new ObjectId($req->countryId);
            }
            $inputArr['department'] = new ObjectId($req->department);
            $inputArr['designation'] = new ObjectId($req->designation);
            
            $update->update($inputArr);
            
            $message = "Updated successfully";
        }else{
            
            if(session()->has('admin')){
                $inputArr['admin_id'] = new ObjectId(session()->get('admin')->id); 
                
            }
         
            if(session()->has( 'team')){
              
                $inputArr['createdByTeamId'] = new ObjectId(session()->get('team')->id);
               
            }
            if(session()->has( 'branch')){
                $inputArr['createdByBranchId'] = new ObjectId(session()->get('branch')->id);
            }
            $lastNumber = Team::max('employeeIdCode');
            $newNumber = str_pad((int)substr($lastNumber, 3) + 1, 4, '0', STR_PAD_LEFT);
            $inputArr['employeeIdCode'] = 'SRL' . $newNumber;
          
            $insertData = Team::create($inputArr);

            #default permission
            $teamId = new ObjectId($insertData->_id);
            $departmentId = new ObjectId($req->department);
            $parentIds = array_map(fn($id) => new ObjectId($id), ['67966b6730b53221d12f0eb3']);
            $childIds = array_map(fn($id) => new ObjectId($id), ['6796602e30b53221d12f0e98']);
            

            TeamPermission::updateOrInsert(
                [
                        'teamId' => $teamId
                    ], 
                    [
                        'departmentId' => $departmentId,
                        'parentId' => $parentIds,
                        'childId' => $childIds,
                    ]
                );
                
            $message = "Created successfully";
        }
      
        if(session()->has('team') && session()->get('team')->department == '6790b8df2ef8f2064c61d079'){
            return back()->with('success', $message);
        }
        
        return redirect(route($prefix.'.team.listTeam'))->with('success', $message);

    }
    public function listTeam(Request $req){

        $team_id = session()->has('team') ? session()->get('team')->id : '';
        $branch_id = session()->has('branch') ? session()->get('branch')->id : '';
        $admin_id = session()->has('admin') ? session()->get('admin')->id : '';
        
        
        $List = Team::with(['designation1', 'department1','branches'])
            ->when($req->name, function ($query) use ($req) {
                $query->where('name', 'like', '%' . $req->name . '%');
            })
            ->when($branch_id, function ($query) use ($branch_id) {
                $query->where('branchId', new ObjectId($branch_id));
            })
            ->when($team_id, function ($query) use ($team_id) {
                if(session()->has('team') && (string) session()->get('team')->designation=='6790b9662ef8f2064c61d07e'){
                        // sales manager  entire team member list
                       
                        $leads = Lead::with('assignedTeam')
                                    ->where(function ($query) use ($team_id) {
                                        $query->where('careatedTeamId', $team_id)
                                            ->orWhere('careatedTeamId', new ObjectId($team_id))
                                            ->orWhere('unassignTeamId', new ObjectId($team_id))
                                            ->orWhere('assign_to_sales', new ObjectId($team_id));
                                    })
                                    ->get();
                        
                            $assignedTeamIds = $leads
                                    ->pluck('assignedTeam._id')
                                    ->filter()         // remove nulls
                                    ->unique()         // remove duplicates
                                    ->map(function ($id) {
                                        return $id instanceof ObjectId ? $id : new ObjectId($id);
                                    })
                                    ->values()         // reset indexes
                                    ->toArray();
                           
                       $query->whereIn('_id', $assignedTeamIds);
                   
                }else{
                     //hr subadmin / hr
                    if(session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->get('team')->department=='67bd6d68d4de44c0093ea46f'){
                        $query->where('branchId', new ObjectId(session()->get('team')->branchId));
                    }else{
                        $query->where('createdByTeamId', new ObjectId($team_id));
                    }
                } 
            })
            // ->when($admin_id, function ($query) use ($admin_id) {
            //     $query->where('admin_id', new ObjectId($admin_id));
            // })
            ->when($req->department, function ($query) use ($req) {
                $query->where('department', new ObjectId($req->department));
            })
            ->latest()
            ->paginate(20);
         
            $department = Department::get();
        return view('admin.team.listTeam', compact('department','List')); 

    }
    public function updateTeam($id){
        $department = Department::get();
        $singleData = Team::find($id);
        $designation = Designation::where('departmentId', (string) new ObjectId($singleData->department))->get();
        $branch  = Branch::where('status',"1")->orderBy('branch_name','asc')->get();
       
        return view('admin.team.addTeam', compact('branch','department', 'designation','singleData'));
    }
    public function deleteTeam($id){
        $teamId = new ObjectId($id);
        $LeadData = Lead::where('careatedTeamId', $teamId)->orWhere('team_id', $teamId)->first();
        $clientData = Client::where('createdByTeamId', $teamId)->orWhere('assignByTeamId', $teamId)->first();
        if($LeadData || $clientData){
            return redirect()->back()->with('error', 'Data exists...');
        }
       
        Team::where('_id',  $id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
    public function teamPermission(Request $req){
    
        $singleData = Team::find($req->team);
      
        $menuPermission  = DepartmentPermission::where('departmentId', new ObjectId($req->department))->first();
       
        if(empty($menuPermission)){
            abort(404);
        }

        $menuList = Menu::whereIn('_id', $menuPermission->parentId)->get();
        $List = [];

        foreach($menuList as $key=>$menu){
            
            $List[] = [
                    'parentData' => $menu,
                    'childData'  => MenuRoute::where('parentId', new ObjectId($menu->_id))->whereIn('_id', $menuPermission->childId)->where('isVisible',"1")->get()
                ];
        }
       
        $teamPermission = TeamPermission::where('teamId', new ObjectId($req->team))->first();
        
        $parentId = [];
        $childId = [];
       
        if(!empty($teamPermission)){
            
            $parentId = $teamPermission->parentId;
            $childId = $teamPermission->childId;
        }
        if(session()->has('admin')){
            $prefix = 'admin';
        }
        
        if(session()->has('team')){
            $prefix = 'team';
        }
        if(session()->has('branch')){
            $prefix = 'branch';
        }

        return view('admin.team.permission', compact('List','singleData','parentId','childId'));
    }
    public function saveTeamPermission(Request $req){
        if(session()->has('admin')){
            $prefix = 'admin';
        }
        
        if(session()->has('team')){
            $prefix = 'team';
        }
        if(session()->has('branch')){
            $prefix = 'branch';
        }
        
       try{
        $validated = $req->validate([
            'teamId' => 'required|string',
            'departmentId' => 'required|string',
            'parentId' => 'required|array',
            'childId' => 'required|array',
        ]);

        $teamId = new ObjectId($validated['teamId']);
        $departmentId = new ObjectId($validated['departmentId']);
        $parentIds = array_map(fn($id) => new ObjectId($id), $validated['parentId']);
        $childIds = array_map(fn($id) => new ObjectId($id), $validated['childId']);
        
        TeamPermission::updateOrInsert(
            [
                    'teamId' => $teamId
                ], 
                [
                    'departmentId' => $departmentId,
                    'parentId' => $parentIds,
                    'childId' => $childIds,
                ]
            );
           
           
            $message = "Permission Added Successfully";
            return redirect(route($prefix.'.team.listTeam'))->with('success', $message);
      
        } catch (\Illuminate\Validation\ValidationException $e) {
           
            TeamPermission::where('teamId',new ObjectId($req->teamId))->delete();
            return redirect(route($prefix.'.team.listTeam'))->with('success', 'Permission Removed');
      
        }catch(Exception $e){
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving permissions: ' . $e->getMessage()]);
        }
    }
    public function profileView($id){
        $country = Country::get();
        $department = Department::get();
        $singleData = Team::with('designation1','department1')->where('_id', new ObjectId($id))->first();
        $designation = Designation::where('departmentId', (string) $singleData->department)->get();
        $personalInfo = TeamProfile::where('employeeId',new ObjectId($id))->first();
        $familyInformations = TeamFamilyInformations::where('employeeId', new ObjectId($id))->get();
        $educationInformation = TeamEducationInformations::where('employeeId', new ObjectId($id))->get();
        $experience = TeamExperience::where('employeeId', new ObjectId($id))->get();
        return view('admin.team.proifile', compact('singleData','country','department','designation','personalInfo','familyInformations','educationInformation','experience'));
    }
    public function savePersonalInTeam(Request $req){
        $inputArr = $req->except('_token');
        $inputArr['employeeId'] = new ObjectId($req->id);
       
        TeamProfile::updateOrCreate(
            ['employeeId' => $inputArr['employeeId']], 
            $inputArr 
        );

        return back()->with('success','Profile updated successfully');
    }
    public function saveTeamFamily(Request $req){
        
        $inputArr = $req->except('_token');
        $inputArr['employeeId'] = new ObjectId($req->id);
        
        if(isset($req->familyid)){
            unset($inputArr['familyid']);
            unset($inputArr['id']);
            
            TeamFamilyInformations::where('_id', new ObjectId($req->familyid))->where('employeeId', new ObjectId($req->id))->update($inputArr);
            return back()->with('success','Family details updated successfully');
        }else{
            
            TeamFamilyInformations::create($inputArr);
            return back()->with('success','Family details addded successfully');
        }
        

        
    }
    public function deleteFamily($id){
        TeamFamilyInformations::where('_id',new ObjectId($id))->delete();
        return back()->with('success','Delete successfully');
    }
    public function saveTeamEducation(Request $req){
        $inputArr = $req->except('_token');
        $inputArr['employeeId'] = new ObjectId($req->id);
        
        TeamEducationInformations::create($inputArr);
        return back()->with('success',value: 'Education informations created successfully');
    }
    public function deleteEducation($id){
        TeamEducationInformations::where('_id',new ObjectId($id))->delete();
        return back()->with('success','Delete successfully');
    }
    public function saveExperienceTeam(Request $req){
        $inputArr = $req->except('_token');
        $inputArr['employeeId'] = new ObjectId($req->id);
        
        TeamExperience::create($inputArr);
        return back()->with('success','Experience added successfully');

    }
    public function deleteExperience($id){
        TeamExperience::where('_id',new ObjectId($id))->delete();
        return back()->with('success','Delete successfully');
    }
}
