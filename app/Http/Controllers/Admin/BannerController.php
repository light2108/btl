<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(){
        $banners=Banner::all();
        Session::put('page', 'banners');
        return View('admin.banners.banners', compact('banners'));
    }
    public function addbanner(Request $request){
        $data=$request->all();
        $data['link']=$data['title'];
        if($request->hasFile('image')){
            $image=$request->file('image');
            $reimage=rand(100, 100000000).'.'.$image->getClientOriginalExtension();

            $dest=public_path('/imgs');
            $image->move($dest, $reimage);
            $data['image']=$reimage;
            Banner::create($data);
            return redirect()->back()->with('success_message', 'Banner has been created');
        }


    }
    public function editbanner(Request $request, $id){
        $banner=Banner::find($id);
        $data=$request->all();
        // dd($data);
        $data['link']=$data['title'];
        if($request->hasFile('image')){
            $image=$request->file('image');
            $reimage=rand(100, 100000000).'.'.$image->getClientOriginalExtension();

            $dest=public_path('/imgs');
            $image->move($dest, $reimage);
            $data['image']=$reimage;
            $banner->update($data);
            return redirect()->back()->with('success_message', 'Banner has been updated');

        }else{
            $banner->update($data);
            return redirect()->back()->with('success_message', 'Banner has been updated');
        }
        // dd($data['status']);

    }
    public function deletebanner($id){
        Banner::find($id)->delete();
        return redirect()->back()->with('success_message', 'Banner has been deleted');
    }
    public function updatebannerstatus(Request $request){
        $data=$request->all();
        if($data['status']=="Active"){
            $status=0;
        }else{
            $status=1;
        }
        Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$data['status']]);
    }
}
