<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use Whoops\Run;

class UserController extends Controller
{
    public function loginregister(){
        return View('frontend.users.login_register');
    }
    public function registeruser(Request $request){
        $data=$request->all();
        // dd($data);
        $request->validate(
            [
                'password'=>'min:6|max:8'
            ]
        );
        $userCount=User::where('email', $data['email'])->count();
        if($userCount>0){
            return redirect()->back()->with('error_message', 'Email already exists!');
        }else{
            User::create(['name'=>$data['name'], 'mobile'=>$data['mobile'], 'password'=>Hash::make($data['password']),'address'=>$data['address'], 'email'=>$data['email']]);
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                if(!empty(Session::get('session_id'))){
                    $user_id=Auth::user()->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/cart')->with('success_message', "Register successfully, welcome to website");
            }
        }

    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function loginuser(Request $request){
        $data=$request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            if(!empty(Session::get('session_id'))){
                $user_id=Auth::user()->id;
                $session_id=Session::get('session_id');
                Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
            }
            return redirect('/cart')->with('success_message', "Login successfully");
        }else{
            return redirect()->back()->with('errorx_message', 'Email or Password is invalid');
        }
    }
    public function forgotpassword(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $emailCount=User::where('email', $data['email'])->count();
            if($emailCount==0){
                return redirect()->back()->with('error_message', 'Email does not exists!');
            }else{
                $new_password=rand(10000000, 99999999);
                $hash_new_password=Hash::make($new_password);
                User::where('email', $data['email'])->update(['password'=>$hash_new_password]);
                $userName=User::select('name', 'mobile', 'email')->where('email', $data['email'])->first()->toArray();
                return View('frontend.users.new_password', compact('userName', 'new_password'));
            }
        }
        return View('frontend.users.forgot_password');
    }
    public function account(Request $request){
        // dd(Hash::make(123));
        $account=User::find(Auth::user()->id)->toArray();
        return View('frontend.users.account', compact('account'));
    }
    public function updateaccount(Request $request){
        $data=$request->all();
        User::find(Auth::user()->id)->update($data);
        return redirect()->back()->with('success_message', 'Account Profile is updated successfully');
    }
    public function updatepasswordaccount(Request $request){
        $data=$request->all();
        if(Hash::make($data['password'])==Auth::user()->password){
            return redirect()->back()->with('errorx_message', 'Password is not correct');
        }else{
            if($data['new_password']==$data['confirm_password']){
                User::find(Auth::user()->id)->update(['password'=>Hash::make($data['new_password'])]);
                return redirect()->back()->with('successx_message', 'Your password is updated successfully');
            }else{
                return redirect()->back()->with('errorx_message', 'New password and confirm password is not same');
            }
        }
    }

}
