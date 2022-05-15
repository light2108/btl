<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        return View('admin.admin_dashboard');
    }
    public function settings(){
        Session::put('page', 'settings');
        // dd(Auth::guard('admin')->user());
        $admindetails=Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return View('admin.admin_settings', compact('admindetails'));
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                return redirect('/admin/dashboard');
            }else{
                Session::flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }
        }
        return View('admin.admin_login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function checkcurrentpassword(Request $request){
        $data=$request->all();
        // print_r(Auth::guard('admin')->user()->password);
        if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
            print('true');
        }else{
            print('false');
        }
    }
    public function updatecurrentpassword(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                if($data['new_password']==$data['confirm_password']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    Session::flash('success_message', 'Your password has been updated successfully');
                    return redirect()->back();
                }else{
                    Session::flash('error_message', 'Your new password and confirm password not same');
                    return redirect()->back();
                }
            }else{
                Session::flash('error_message', 'Your current password is incorrect');
                return redirect()->back();
            }
        }
    }
    public function updateadmindetails(Request $request){
        Session::put('page', 'update-admin-details');
        $admindetails=Admin::where('email', Auth::guard('admin')->user()->email)->first();
        if($request->isMethod('post')){
            $request->validate([
                'name'=>'regex:/^[\pL\s\-]+$/u'
            ]);
            $data=$request->all();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $reimage = time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile'=>$data['mobile'], 'image'=>$reimage, 'email'=>$data['email'], 'type'=>$data['type'], 'status'=>($data['status']=='active')?1:0 or ($data['status']=='inactive')?0:1, 'name'=>$data['name']]);
                Session::flash('success_message', 'Your profile has been updated successfully');
                return redirect()->back();
            }else{
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile'=>$data['mobile'], 'image'=>$admindetails->image, 'email'=>$data['email'], 'type'=>$data['type'], 'status'=>($data['status']=='active')?1:0 or ($data['status']=='inactive')?0:1, 'name'=>$data['name']]);
                Session::flash('success_message', 'Your profile has been updated successfully');
                return redirect()->back();
            }
        }
        return View('admin.update_admin_details', compact('admindetails'));
    }
    // public function viewimage(){
    //     $admindetails=Admin::where('email', Auth::guard('admin')->user()->email)->first();
    //     return View('admin.admin_image', compact('admindetails'));
    // }
}
