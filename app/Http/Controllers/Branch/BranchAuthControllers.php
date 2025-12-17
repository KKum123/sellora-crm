<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\ERP\Branch;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BranchAuthControllers extends Controller
{
    public function login(Request $req){
     
        if ($req->isMethod('post')) {
            $this->validate($req, [
                'email'    => 'required|email',
                'password' => 'required',
            ]);
          
            if(Branch::where('email', $req->email)->where('status',0)->exists()){
                return back()->with('error', 'Your account is deactivated. Please contact Admin.');
            }

            if (Auth::guard('branch')->attempt($req->only('email', 'password'))) {
                auth()->guard('admin')->logout();
                auth()->guard('team')->logout();
                session()->forget('admin');
                session()->forget('team');

                session()->put('branch', Auth::guard('branch')->user());
                return redirect()->route('branch.dashboard');
            } else {
                return back()->with('error', 'Whoops! Invalid email or password.');
            }
        }
        if(auth('branch')->check()){
            return redirect()->route('branch.dashboard');
        }else{
            return view('branch.login');
        }
        
    }
    public function logout(Request $request)
    {
        auth()->guard('branch')->logout();
        session()->forget('branch');
        return redirect('/login?authType=Branch');
    }
    public function changePassword(){
        return view('admin.change-password');
    }
    public function ChangePasswordSave(Request $req)
    {
        
        $admin_id =  session()->get('branch')->_id;
       
        $user = Branch::findOrFail($admin_id);

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
                    ->with('error' , 'New Password and Confirm Password does not match');
        }
		else  if (!Hash::check($req->old_password, $user->password)) {
                // The passwords matches
                return redirect()
                    ->back()
                    ->with('error' ,'Your current password does not matches with the password you provided. Please try again.');
         }else   if ($req->old_password == $req->new_password) {
                //Current password and new password are same
                // return redirect()
                //     ->back()
                //     ->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
                return redirect()
                    ->back()
                    ->with('error' , 'New Password cannot be same as your current password. Please choose a different password.');
            } else {
                $userObj = Branch::find($user->id);
                $userObj->password = Hash::make($req->new_password);
                $userObj->show_password = base64_encode($req->new_password);
                $userObj->save();

			return redirect()->route('branch.dashboard')->with('success', 'Password Updated Successfully.');

            // ->with(['message' => 'Password Updated Successfully', 'alert-type' => 'success']);
            }
    }
}
