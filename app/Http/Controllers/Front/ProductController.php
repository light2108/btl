<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attr_Product;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_Product;

class ProductController extends Controller
{
    public function listing()
    {
        $url = Route::getFacadeRoot()->current()->uri();
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {
            $categoryDetails = Category::catDetails($url);
            // dd($categoryDetails);
            // echo "<pre>"; print_r($categoryDetails); die;
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->paginate(3);
            // dd($categoryProducts);
            // dd($categoryDetails['catIds']);
            // $categoryProduct=Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->paginate(3);
            // echo "<pre>"; print_r($categoryProducts); die;
            if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                if ($_GET['sort'] == "product_lastest") {
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->orderBy('id', 'Desc')->paginate(3);
                } else if ($_GET['sort'] == "product_name_a_z") {
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->orderBy('product_name', 'Asc')->paginate(3);
                } else if ($_GET['sort'] == "product_name_z_a") {
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->orderBy('product_name', 'Desc')->paginate(3);
                } else if ($_GET['sort'] == "price_highest") {
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->orderBy('product_price', 'Desc')->paginate(3);
                } else if ($_GET['sort'] == "price_lowest") {
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->orderBy('product_price', 'Asc')->paginate(3);
                }
            }
            // $categoryProducts=$categoryProducts->paginate(3);
            return View('frontend.products.listing', compact('categoryDetails', 'categoryProducts'));
        } else {
            abort(404);
        }
    }
    public function detail($id)
    {
        $productDetail = Product::with(['brand', 'attributes' => function ($query) {
            $query->where('status', 1);
        }, 'images', 'category'])->find($id)->toArray();
        // $attributes=Attr_Product::where('product_id', $id)->get()->toArray();
        // dd($productDetail);
        $total_stock = Attr_Product::where('product_id', $id)->sum('stock');
        $relatedProducts = Product::where('category_id', $productDetail['category']['id'])->where('id', '!=', $id)->limit(3)->inRandomOrder()->get()->toArray();
        // dd($relatedProducts);
        return View('frontend.products.detail', compact('productDetail', 'total_stock', 'relatedProducts'));
    }
    public function getproductprice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // $getProductPrice=Attr_Product::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first();
            // dd($getProductPrice);
            $getDiscountedPrice = Product::getDiscountAttrPrice($data['product_id'], $data['size']);
            // dd($getDiscountedPrice);
            // $discount_product=Product::find($data['product_id']);
            // dd($getDiscountedPrice);
            return $getDiscountedPrice;
            // echo "<pre></pre>"; print_r($getProductPrice); die;
        }
    }
    public function addtocart(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $getProductStock = Attr_Product::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first()->toArray();
        // dd($getProductStock);
        if ($getProductStock['stock'] < $data['quantity']) {
            return redirect()->back()->with('error_message', 'Required Quantity is not available');
        } else {
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }
            if (Auth::check()) {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => Auth::user()->id])->count();
            } else {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => Session::get('session_id')])->count();
            }

            if ($countProducts > 0) {
                return redirect()->back()->with('error_message', 'Product already exists in Cart');
            }
            if ($data['quantity'] > 0) {
                $cart = new Cart;
                if (Auth::check()) {
                    $cart->user_id = Auth::user()->id;
                } else {
                    $cart->user_id = 0;
                }
                $cart->quantity = $data['quantity'];
                $cart->session_id = $session_id;
                $cart->product_id = $data['product_id'];
                $cart->size = $data['size'];
                $cart->save();
            } else {
                return redirect()->back()->with('error_message', 'Quantity Product must be greater than 0');
            }
            // Cart::insert(['session_id'=>$session_id, 'product_id'=>$data['product_id'], 'size'=>$data['size'], 'quantity'=>$data['quantity']]);
            return redirect('/cart')->with('success_message', 'Product has been added in Cart');
        }
    }
    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        // dd(Session::get('grand_total'));
        // dd(User::countquantity());
        return View('frontend.products.cart', compact('userCartItems'));
    }
    public function updatecartitemqty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // dd($data);

            $cartDetails = Cart::find($data['cartid']);
            $availableStock = Attr_Product::select('stock')->where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size']])->first()->toArray();
            if ($data['new_qty'] > $availableStock['stock']) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Stock is not available',
                    'view' => (string)View::make('frontend.products.cart_items')->with(compact('userCartItems'))
                ]);
            }
            $availableSize = Attr_Product::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size'], 'status' => 1])->count();
            if ($availableSize == 0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size is not available',
                    'view' => (string)View::make('frontend.products.cart_items')->with(compact('userCartItems'))
                ]);
            }
            Cart::where('id', $data['cartid'])->update(['quantity' => $data['new_qty']]);
            $userCartItems = Cart::userCartItems();
            return response()->json([
                'status' => true,
                'view' => (string)View::make('frontend.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }
    public function deletecartitem(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Cart::where('id', $data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            return response()->json([
                'status' => true,
                'view' => (string)View::make('frontend.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }
    public function contactus()
    {
        // Session::put('xxx', 'contactus');
        return View('frontend.products.contact_us');
    }
    public function applycoupon(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $userCartItems = Cart::userCartItems();
            // dd($userCartItems);
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if ($couponCount == 0) {
                return response()->json(['status' => false, 'message' => 'This coupon is not valid!', 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
            } else {

                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if ($expiry_date <= $current_date) {
                    $message = 'This coupon is expired!';
                }
                $catArr = explode(',', $couponDetails->categories);
                foreach ($userCartItems as $key => $item) {
                    if (!in_array($item['product']['category_id'], $catArr)) {
                        $message = 'This coupon is not for one of the selected products!';
                        // return response()->json(['status' => false, 'message' => 'This coupon is not for one of the selected products!', 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
                    }
                }
                if (!empty($couponDetails->user)) {
                    $usersArr = explode(',', $couponDetails->user);
                    // foreach($usersArr as $key=>$user){
                    //     $getUserID=User::select('id')->where('email', $user)->first()->toArray();
                    //     $userID[]=$getUserID['id'];
                    // }
                    $total_amount = 0;
                    foreach ($userCartItems as $key => $item) {
                        if (!in_array($item['user_id'], $usersArr)) {
                            $message = 'You can not use this coupon!';
                            // return response()->json(['status' => false, 'message' => 'You can not use this coupon!', 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
                        }
                        $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                        $total_amount += $attrPrice['discounted_price'] * $item['quantity'];
                    }
                }
                if ($couponDetails->status == 0) {
                    $message = 'This coupon is not active!';
                    // return response()->json(['status' => false, 'message' => 'This coupon is not active!', 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
                }
                if (isset($message)) {
                    return response()->json(['status' => false, 'message' => $message, 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
                } else {
                    if ($couponDetails->amount_type == "Fixed") {
                        $couponAmount = $couponDetails->amount;
                    } else {
                        $couponAmount = $total_amount - ($couponDetails->amount / 100);
                    }
                    $couponTypeAmount = 0;
                    if ($couponDetails->coupon_type == "Multiple Times") {
                        for ($i = 0; $i < $data['dem']; $i++) {
                            $couponTypeAmount += $couponAmount;
                        }
                    } else {
                        $couponTypeAmount = $couponAmount;
                        if($data['dem']>1){
                            return response()->json(['status' => false, 'message' => "This coupon just use one time!", 'view' => (string)View::make('frontend.products.cart_items', compact('userCartItems'))]);
                        }
                    }
                    $grand_total = $total_amount - $couponTypeAmount;
                    // if($couponDetails->coupon_type=="Multiple Times"){
                    //     $couponAmount+=$couponAmount;
                    // }
                    $itemcartqty=User::countquantity();
                    $message = 'Coupon code applied successfully';
                    Session::put('couponAmount', $couponTypeAmount);
                    Session::put('couponCode', $data['code']);
                    // Session::put('grand_total', $grand_total);
                    return response()->json(['status' => true, 'message' => $message, 'itemcartqty'=>$itemcartqty, 'grand_total' => $grand_total, 'couponAmount' => $couponTypeAmount, 'view' => (string)View::make('frontend.products.cart_items')->with(compact('userCartItems'))]);
                }

            }

        }
    }

}
