<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Models\Category;
// Auth::routes();
Route::prefix('/admin')->namespace('Admin')->group(function(){
    Route::match(['get', 'post'], '/', 'AdminController@login');

    Route::group(['middleware'=>'admin'], function(){
        Route::get('/dashboard', 'AdminController@dashboard');
        Route::get('settings', 'AdminController@settings');
        Route::get('logout', 'AdminController@logout');
        Route::post('check-current-pwd', 'AdminController@checkcurrentpassword');
        Route::post('update-current-pwd', 'AdminController@updatecurrentpassword');
        Route::match(['get', 'post'], '/update-admin-details', 'AdminController@updateadmindetails');
        Route::get('/view-image', 'AdminController@viewimage');
        ///Section
        Route::get('sections', 'SectionController@sections');
        Route::post('update-section-status', 'SectionController@updatesectionstatus');
        ///Categories
        Route::get('categories', "CategoryController@categories");
        Route::post('update-category-status', 'CategoryController@updatecategorystatus');
        Route::match(['get', 'post'], '/add-category', 'CategoryController@addcategory');
        Route::match(['get', 'post'], '/edit-category/{id}', 'CategoryController@editcategory');
        Route::get('/delete-category/{id}', 'CategoryController@deletecategory');
        Route::post('/append-category-categories-level', 'CategoryController@appendcategorieslevel');
        //Products
        Route::get('products', 'ProductController@products');
        Route::post('/update-product-status', 'ProductController@updateproductstatus');
        Route::match(['get', 'post'], '/add-product', 'ProductController@addproduct');
        Route::match(['get', 'post'], '/edit-product/{id}', 'ProductController@editproduct');
        Route::post('/append-categories-level', 'ProductController@appendcategorieslevel');
        Route::get('/delete-product/{id}', 'ProductController@deleteproduct');
        Route::post('/append-product-categories-level', 'ProductController@appendcategorieslevel');
        ///Attribute Product
        Route::match(['get', 'post'], '/attr-product/{id}', 'ProductController@addAttributes');
        Route::get('/delete-attribute/{product_id}/product/{id}',['as'=>'delete.attribute.product','uses'=>'ProductController@deleteattributeproduct']);
        Route::post('/edit-attribute-product/{id}', 'ProductController@editattributeproduct');
        Route::post('/update-attribute-status', 'ProductController@updateattrstatus');
        Route::match(['get', 'post'], '/add-images/{id}', 'ProductController@addimages');
        ///Image Product
        Route::get('/delete-attribute/{product_id}/image/{id}',['as'=>'delete.attribute.image','uses'=>'ProductController@deleteattributeimage']);
        Route::match(['get', 'post'], '/edit-attribute/{id}', 'ProductController@editattributeimage');
        Route::post('/update-product-image-status', 'ProductController@updateproductimagestatus');
        ///Brand
        Route::get('/brands', 'BrandController@brands');
        Route::post('/update-brand-status', 'BrandController@updatebrandstatus');
        Route::post('/add-brand', 'BrandController@addbrand');
        Route::get('/delete-brand/{id}', 'BrandController@deletebrand');
        Route::match(['get', 'post'], '/edit-brand/{id}', 'BrandController@editbrand');
        Route::get('/showvideo/{id}', 'ProductController@showvideo');
        //Banner
        Route::get('banners', 'BannerController@index');
        Route::post('add-banner', 'BannerController@addbanner');
        Route::post('edit-banner/{id}', 'BannerController@editbanner');
        Route::get('delete-banner/{id}', 'BannerController@deletebanner');
        Route::post('/update-banner-status', 'BannerController@updatebannerstatus');

        Route::post('/edit-image-product/{id}', 'ProductController@editimageproduct');

        Route::get('/coupons', 'CouponController@coupons');
        // Route::post('/add-coupon', 'CouponController@addcoupon');
        Route::match(['get', 'post'], '/add-coupon', 'CouponController@addcoupon');
        Route::get('/delete-coupon/{id}', 'CouponController@deletecoupon');
        Route::match(['get', 'post'], '/edit-coupon/{id}', 'CouponController@updatecoupon');
        Route::post('/update-coupon-status', 'CouponController@updatecouponstatus');

        Route::get('/user-order', 'OrderController@order');
        Route::post('/check-order/{id}', 'OrderController@checkorder');
    });

});
Route::namespace('Front')->group(function(){
    Route::get('/', 'IndexController@index');

    $catUrls=Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    // dd($catUrls);
    foreach($catUrls as $url){
        Route::get('/'.$url, 'ProductController@listing');
    }
    //Product Details
    Route::get('/product/{id}', 'ProductController@detail');
    Route::post('/get-product-price', 'ProductController@getproductprice');
    Route::post('/add-to-cart', 'ProductController@addtocart');
    Route::get('/cart', 'ProductController@cart');
    Route::post('/update-cart-item-qty', 'ProductController@updatecartitemqty');
    Route::get('/delete-cart-item', 'ProductController@deletecartitem');
    Route::get('/login-register', 'UserController@loginregister');
    Route::post('/login', 'UserController@loginuser');
    Route::post('/register', 'UserController@registeruser');
    Route::get('/logout', 'UserController@logout');
    Route::get('/contact-us', ['as'=>'frontend.contact_us', 'uses'=>'ProductController@contactus']);
    Route::match(['get', 'post'], '/forgot-password', 'UserController@forgotpassword');
    Route::group(['middleware'=>['auth']], function(){

        Route::get('/account', 'UserController@account');
        Route::post('/update-account', 'UserController@updateaccount');
        Route::post('/update-password-account', 'UserController@updatepasswordaccount');
        Route::post('/apply-coupon', 'ProductController@applycoupon');
        Route::match(['get', 'post'], '/order', ['as'=>'frontend.order', 'uses'=>'OrderController@order']);
    });


});
