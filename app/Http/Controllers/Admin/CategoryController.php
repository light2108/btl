<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use App\Models\Sections;
function chuyen($string){
    $string=trim($string);
    return str_replace(" ", "-", $string);
}
class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentcategory'])->get();
        // dd($categories);
        // $categories=Category::with(['section', 'parentcategory'])->get();
        // echo "<pre>"; print_r($categories); die;
        // dd($category);
        return View('admin.categories.categories', compact('categories'));
    }
    public function updatecategorystatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }
    public function addcategory(Request $request)
    {
        $getsection = Sections::all();

        // $category=new Category;
        if ($request->isMethod("POST")) {
            $request->validate(
                [
                    'category_name' => 'unique:categories,category_name',
                    'category_image'=>'mimes:png,jpg'
                ]
            );
            $data = $request->all();

            $data['url'] = chuyen($data['category_name']);
            // Category::create($data);
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');
                $reimage = time() . '.' . $image->getClientOriginalExtension();
                $dest = public_path('/imgs');
                $image->move($dest, $reimage);
                $data['category_image'] = $reimage;
                Category::create($data);
                Session::flash('success_message', 'Your category has been added');
                return redirect('/admin/categories');
            } else {
                Category::create($data);
                Session::flash('success_message', 'Your category has been added');
                return redirect('/admin/categories');
            }
        }
        return View('admin.categories.add_category', compact('getsection'));
    }
    public function editcategory(Request $request, $id)
    {
        $category = Category::find($id);

        $getsection = Sections::all();
        $categories = Category::all();

        if ($request->isMethod("POST")) {
                $request->validate(
                    [
                        'category_image'=>'mimes:png,jpg'
                    ]
                );
                $data = $request->all();
                $data['url'] = chuyen($data['category_name']);
                if ($request->hasFile('category_image')) {
                    $image = $request->file('category_image');
                    $reimage = time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgs');
                    $image->move($dest, $reimage);
                    $data['category_image'] = $reimage;
                    $category->update($data);
                    Session::flash('success_message', 'Your category has been updated');
                    return redirect('/admin/categories');
                } else {
                    // $data['category_image']=$data['category_image'];
                    $category->update($data);
                    Session::flash('success_message', 'Your category has been updated');
                    return redirect('/admin/categories');
                }
            }
            return View('admin.categories.edit_category', compact('category', 'getsection', 'categories'));
        }


    public function deletecategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('/admin/categories')->with('success_message', 'Your category has been deleted');
    }
    public function appendcategorieslevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // print_r($data);
            $getcategories = Category::with('subcategories')->where(['section_id'=> $data['section_id'], 'parent_id'=>0])->get();
            dd($getcategories);
            return View('admin.categories.append_categories', compact('getcategories'));
        }
    }
}
