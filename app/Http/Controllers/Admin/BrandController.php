<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::all();
        Session::put('page', 'brands');
        return View('admin.brands.brands', compact('brands'));
    }
    public function updatebrandstatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json(['status' => $data['status']]);
        }
    }
    public function addbrand(Request $request)
    {

        $data = $request->all();
        Brand::create($data);
        return redirect()->back()->with('success_message', 'Brand has been created');
    }
    public function deletebrand(Request $request, $id)
    {
        Brand::find($id)->delete();
        return redirect()->back()->with('success_message', 'Brand has been deleted');
    }
    public function editbrand(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Brand::find($id)->update(['name' => $data['name'], 'status' => $data['status']]);
            return redirect()->back()->with('success_message', 'Brand has been updated');
        }

    }
}
