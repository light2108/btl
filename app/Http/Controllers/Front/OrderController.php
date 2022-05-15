<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attr_Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order_Product;
use App\Models\Cart;
use App\Models\CheckOrder;
class OrderController extends Controller
{
    public function order(Request $request){
        // dd(Session::get('couponCode'));
        $orders=Order::with('order_product')->with('check_order')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        // dd($orders);
        // $checkorder=Order::with('check_order')->where('user_id', Auth::user()->id)->get()->toArray();
        // dd($checkorder);
        if($request->isMethod('post')){
            $data=$request->all();
            $order=new Order();
            $order->user_id=Auth::user()->id;
            $order->name=Auth::user()->name;
            $order->address=Auth::user()->address;
            $order->mobile=Auth::user()->mobile;
            $order->email=Auth::user()->email;
            $order->shipping_charges=0;
            $order->coupon_code=Session::get('couponCode');
            $order->coupon_amount=Session::get('couponAmount');
            $order->order_status="New";
            $order->grand_total=Session::get('grand_total');
            $order->save();
            $checkorder=new CheckOrder();
            $checkorder->order_id=$order->id;
            $checkorder->status=0;
            $checkorder->save();
            $cartItems=Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach($cartItems as $key=>$item) {
                $cartItem=new Order_Product();
                $cartItem->user_id=Auth::user()->id;
                $cartItem->order_id=$order->id;
                $cartItem->product_id=$item['product_id'];
                $getProductDetails=Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_code=$getProductDetails['product_code'];
                $cartItem->product_name=$getProductDetails['product_name'];
                $cartItem->product_color=$getProductDetails['product_color'];
                $cartItem->product_size=$item['size'];
                $getDiscountedAttrPrice=Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                $cartItem->product_price=$getDiscountedAttrPrice['discounted_price'];
                $cartItem->product_qty=$item['quantity'];
                $cartItem->save();
                $pro_attr=Attr_Product::where('product_id', $item['product_id'])->where('size', $item['size'])->first();
                $pro_attr->update(['stock'=>$pro_attr->stock-$item['quantity']]);
            }
            Session::put('order_id', $order->id);
            Session::put('check', 1);
            return response()->json(['status'=>true]);
        }
        return View('frontend.orders.orders', compact('orders'));
    }

}
