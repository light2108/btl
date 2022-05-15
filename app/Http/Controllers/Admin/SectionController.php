<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Sections;
use Illuminate\Support\Facades\Route;
class SectionController extends Controller
{
    public function sections(Request $request){
        Session::put('page', 'sections');
        $sections=Sections::all();
        return View('admin.sections.sections', compact('sections'));
    }
    public function updatesectionstatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            Sections::where('id', $data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'section_id'=>$data['section_id']]);
        }
    }
}
