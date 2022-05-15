<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CheckOrder;
class OrderController extends Controller
{
    public function order(Request $request){
        Session::put('page', 'user-order');
        $orders=Order::with('order_product')->with('check_order')->get()->toArray();
        // $checkorder=Order::with('check_order')->get()->toArray();
        // dd($orders)
        return View('admin.orders.orders', compact('orders'));
    }
    public function checkorder(Request $request, $id){
        if($request->isMethod('post')){
            CheckOrder::where('order_id', $id)->update(['status'=>1]);
            // Order::with('order_product')->find($id)->delete();
            return redirect()->back();
        }
    }
}
