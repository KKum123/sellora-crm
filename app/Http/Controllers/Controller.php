<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\ERP\Branch;
use App\Models\ERP\Team;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use MongoDB\BSON\ObjectId;
use Mail;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function loginTeam(Request $req){
     
        if($req->teamType=='Team'){
            if ($req->isMethod('post')) {
                $this->validate($req, [
                    'email'    => 'required|email',
                    'password' => 'required',
                ]);
                
               
                if(Team::where('email', $req->email)->where('status',0)->exists()){
                    return back()->with('error', 'Your account is deactivated. Please contact HR.');
                }
    
                if (Auth::guard('team')->attempt($req->only('email', 'password'))) {
                    auth()->guard('admin')->logout();
                    auth()->guard('branch')->logout();
                    session()->forget('admin');
                    session()->forget('branch');
    
                    session()->put('team', Auth::guard('team')->user());
    
                    return redirect()->route('team.dashboard');
                } else {
                   
                    return back()->with('error', 'Whoops! Invalid email or password.');
                }
            }
            if(auth('team')->check()){
                return redirect()->route('team.dashboard');
            }else{
                return view('team.login');
            }
        }
        if($req->teamType=='Branch'){
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
        if($req->teamType=='Super Admin'){
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
                return view('admin.login');
            }
        }
    }
    public function forgotPassword(){
        return view('main.forgot-password');
    }
    public function sendForgotPassword(Request $req){
            
            if($req->teamType == 'Team'){
                $this->validate($req, [
                    'email'    => 'required|email|exists:crm_teams,email'
                ]);

                $user = Team::where('email', $req->email)->first();

            }elseif($req->teamType == 'Branch'){
                $this->validate($req, [
                    'email'    => 'required|email|exists:crm_branches,email'
                ]);
                $user = Branch::where('email', $req->email)->first();

            }elseif($req->teamType == 'Super Admin'){
                $this->validate($req, [
                    'email'    => 'required|email|exists:crm_users,email'
                ]);
                $user = User::where('email', $req->email)->first();

            }

             $token = base64_encode($user->_id);
             $link = url("/reset-password/{$token}?teamType=" . urlencode($req->teamType)."&email=" . urlencode($req->email));
             Mail::to($user->email)->send(new TestMail($user, $link));
            
             return response()->json(['message' => 'Reset link sent to your email.']);
    }
    public function resetPassword($token, Request $req){

        return view('main.reset-password', compact('token','req'));
    }
    public function resetForgotPassword(Request $req){

      
         $req->validate([
                'password' => ['required', 'min:6', 'confirmed'],
            ], [
                'password.confirmed' => 'The password and confirm password must match.',
            ]);

        $password = Hash::make($req->password);
        $show_password = base64_encode($req->password);
       
        $id = new ObjectId(base64_decode($req->id));

        if($req->teamType == 'Team'){
            Team::where('_id', $id)->update([
                'password' => $password,
                'show_password' => $show_password
            ]);
        }elseif($req->teamType == 'Branch'){
            Branch::where('_id', $id)->update([
                'password' => $password,
                'show_password' => $show_password
            ]);
        }elseif($req->teamType == 'Super Admin'){
            User::where('_id', $id)->update([
                'password' => $password,
                'show_password' => $show_password
            ]);
        }
        return response()->json(['message' => 'Reset Password Successfully.']);
    }
}
