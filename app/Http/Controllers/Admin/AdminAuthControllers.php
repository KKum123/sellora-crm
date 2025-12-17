<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ERP\Department;
use App\Models\ERP\DepartmentPermission;
use App\Models\ERP\Menu;
use App\Models\ERP\MenuRoute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use MongoDB\BSON\ObjectId;

class AdminAuthControllers extends Controller
{
    public function login(Request $req){
        
        if ($req->isMethod('post')) {
            $this->validate($req, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (Auth::guard('admin')->attempt($req->only('email', 'password'))) {

                auth()->guard('branch')->logout();
                auth()->guard('team')->logout();
                session()->forget('branch');
                session()->forget('team');
                session()->put('admin', Auth::guard('admin')->user());
                
                return redirect()->route('admin.dashboard');
            } else {
               
                return back()->with('error', 'Whoops! Invalid email or password.');
            }
        }
        if(auth('admin')->check()){
            return redirect()->route('admin.dashboard');
        }else{
            return view('main.login');
        }
        
    }
    public function logout(Request $request)
    {
        
        auth()->guard('admin')->logout();
        session()->forget('admin');
        
        return redirect('/login?authType=Super Admin');
    }
    public function changePassword(){
        return view('admin.change-password');
    }

    public function ChangePasswordSave(Request $req)
    {
        $admin_id =  session()->get('admin')->_id;
        $user = User::findOrFail($admin_id);

        $validator = Validator::make($req->all(), [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6|max:255|',
            'confirm_password' => 'required|min:6|max:255|',
        ]);

        if ($validator->fails()) {
                return redirect()->back()->withInput($req->input())->withErrors($validator->errors());
        }
		else if ($req->new_password != $req->confirm_password) {
                return redirect()
                    ->back()
                    ->with('error','New Password and Confirm Password does not match');
        }
		else  if (!Hash::check($req->old_password, $user->password)) {
                // The passwords matches
                return redirect()
                    ->back()
                    ->with('error','Your current password does not matches with the password you provided. Please try again.');
         }else   if ($req->old_password == $req->new_password) {
                //Current password and new password are same
                // return redirect()
                //     ->back()
                //     ->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
                return redirect()
                    ->back()
                    ->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
            } else {
                $userObj = User::find($user->id);
                $userObj->password = Hash::make($req->new_password);
                $userObj->show_password = base64_encode($req->new_password);
                $userObj->save();

			return redirect()->route('admin.dashboard')->with('success', 'Password Updated Successfully.');

            // ->with(['message' => 'Password Updated Successfully', 'alert-type' => 'success']);
            }
    }
   
    public function departmentPermission(Request $req){
        $departments = Department::all();
        $departmentsWithPermissions = [];
        foreach ($departments as $department) {
            $permissions = DepartmentPermission::where('departmentId', new ObjectId($department->_id))
            ->pluck('parentId')
                   ->flatten() 
                   ->toArray();

            $menu = !empty($permissions) ? Menu::whereIn('_id', $permissions)->get() : [];
         
            $departmentsWithPermissions[] = [
                'department' => $department,
                'permissions' => $menu
            ];
        }
        // dd($departmentsWithPermissions);
        return view('admin.department-permission', compact('departmentsWithPermissions'));
    }
    public function rolePermission(Request $req){
        $singleData = Department::find($req->department);
        $departmentPermission = DepartmentPermission::where('departmentId', new objectId($req->department))->first();
        $parentId = [];
        $childId = [];
       
        if(!empty($departmentPermission)){
            
            $parentId = $departmentPermission->parentId;
            $childId = $departmentPermission->childId;
        }
        
        $menus = Menu::all();
        $menusWithRoutes = $menus->map(function ($menu) {
            $menuRoutes = MenuRoute::where('parentId', new ObjectId($menu->_id))->where('isVisible', "1")->get();
            $menu['routes'] = $menuRoutes;
            
            return $menu;
        });

        $menusArray = $menusWithRoutes->toArray();
        

        return view('admin.role-permission', compact('menusArray','singleData','parentId', 'childId'));
    }

    public function saveDepartmentPermission(Request $req){
        try{
            $validated = $req->validate([
                'departmentId' => 'required|string',
                'parentId' => 'required|array',
                'childId' => 'required|array',
            ]);

            $departmentId = new ObjectId($validated['departmentId']);
            $parentIds = array_map(fn($id) => new ObjectId($id), $validated['parentId']);
            $childIds = array_map(fn($id) => new ObjectId($id), $validated['childId']);
            
            DepartmentPermission::updateOrInsert(
                ['departmentId' => $departmentId], 
                    [
                        'parentId' => $parentIds,
                        'childId' => $childIds,
                    ]
                );

            return redirect()->route('admin.departmentPermission')->with('success', 'Permission Added Successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($req->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 422,
                    'message' => 'Validation error',
                    'errors' => $e->errors(),
                ], 422);
            }
    
            return back()->with('error', $e->getMessage());
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    
}
