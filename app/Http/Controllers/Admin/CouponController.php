<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\User;
use Nette\Utils\Random;

class CouponController extends Controller
{
    public function coupons()
    {
        Session::put('page', 'coupons');
        $categories = Category::all();
        // dd($categories);
        $users = User::all();
        $coupons = Coupon::get()->toArray();
        return View('admin.coupons.coupons', compact('coupons', 'categories', 'users'));
    }
    public function addcoupon(Request $request)
    {
        $categories = Category::all();
        // dd($categories);
        $users = User::all();
        $coupons = Coupon::get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $data['expiry_date'] = date('Y-m-d', strtotime($data['expiry_date']));
            if (isset($data['categories'])) {
                $data['categories'] = implode(',', $data['categories']);
            }
            if (isset($data['user'])) {
                $data['user'] = implode(',', $data['user']);
            }
            if ($data['coupon_option'] == "Automatic") {
                $data['coupon_code'] = str_shuffle('abcdef');
            }
            Coupon::create($data);
            return redirect('/admin/coupons')->with('success_message', 'Coupon has been added successfully');
        }
        return View('admin.coupons.add_coupon', compact('coupons', 'categories', 'users'));
    }
    public function updatecoupon(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $categories = Category::all();
        // dd($categories);
        $users = User::all();
        $cate = array();
        $cate = explode(",", $coupon->categories);
        $use = array();

        $use = explode(",", $coupon->user);
        // dd($category);
        if ($request->isMethod('post')) {
            $data = $request->all();

            $data['expiry_date'] = date('Y-m-d', strtotime($data['expiry_date']));
            $data['categories'] = implode(',', $data['categories']);
            $data['user'] = implode(',', $data['user']);
            if ($data['coupon_option'] == "Automatic") {
                $data['coupon_code'] = str_shuffle('abcdef');
            }
            Coupon::find($id)->update($data);
            return redirect('/admin/coupons')->with('success_message', 'Coupon has been updated successfully');
        }
        return View('admin.coupons.edit_coupon', compact('coupon', 'categories', 'users', 'cate', 'use'));
    }
    public function deletecoupon($id)
    {
        Coupon::find($id)->delete();
        return redirect()->back()->with('success_message', 'Coupon has been deleted successfully');
    }
    public function updatecouponstatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::find($data['coupon_id'])->update(['status' => $status]);
            return response()->json(['status' => $data['status'], 'id' => $data['coupon_id']]);
        }
    }
}
