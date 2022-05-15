<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attr_Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sections;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Products_Images;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::with(['category', 'section'])->get();

        Session::put('page', 'products');
        return View('admin.products.products', compact('products'));
    }
    public function updateproductstatus(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $data['status'], 'product_id' => $data['product_id']]);
        }
    }
    public function addproduct(Request $request)
    {
        $arrays = array('Cotton', 'Wool', 'Polyester');
        $getsection = Sections::where('status', 1)->get();
        // $product = new Product();

        // dd($categories);
        $brands = Brand::where('status', 1)->get();
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'product_code' => "unique:products,product_code",
                    'product_name' => "unique:products,product_name",
                    'main_image' => 'mimes:png,jpg',
                    'product_video' => 'mimes:mp4',

                ]
            );
            $data = $request->all();
            $data['is_featured'] = (isset($data['is_featured'])) ? "Yes" : "No";
            if ($request->hasFile('main_image')) {

                $image = $request->file('main_image');
                if ($image->isValid()) {
                    $reimage = time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgs');
                    $image->move($dest, $reimage);
                    $data['main_image'] = $reimage;
                    Product::create($data);
                    Session::flash('success_message', 'Your product has been created');
                    return redirect('/admin/products');
                }
            } else if ($request->hasFile('product_video')) {

                $file = $request->file('product_video');
                if ($file->isValid()) {
                    $filename = rand(100, 1000000000000) . '.' . $file->getClientOriginalExtension();
                    $path = public_path('/upload');
                    $file->move($path, $filename);
                    $data['product_video'] = $filename;
                    Product::create($data);
                    Session::flash('success_message', 'Your product has been created');
                    return redirect('/admin/products');
                }
            } else {

                Product::create($data);
                return redirect('/admin/products')->with('success_message', 'Product has been created');
            }
        }
        return View('admin.products.add_product', compact('getsection', 'brands', 'arrays'));
    }
    public function editproduct(Request $request, $id)
    {
        $product = Product::find($id);
        // dd($product->product_price);
        $getsection = Sections::all();
        $categories = Category::all();
        $brands = Brand::where('status',1)->get();
        $arrays = array('Cotton', 'Wool', 'Polyester');
        if ($request->isMethod('POST')) {
            $request->validate(
                [

                    'main_image' => 'mimes:png,jpg',
                    'product_video' => 'mimes:mp4',

                ]
            );
            $data = $request->all();
            $data['is_featured'] = (isset($data['is_featured'])) ? "Yes" : "No";
            // $data['product_discount']=$product->product_discount;
            if ($request->hasFile('main_image')) {

                $image = $request->file('main_image');
                if ($image->isValid()) {
                    $reimage = time() . '.' . $image->getClientOriginalExtension();
                    $dest = public_path('/imgs');
                    $image->move($dest, $reimage);
                    $data['main_image'] = $reimage;
                    $product->update($data);
                    Session::flash('success_message', 'Your product has been updated');
                    return redirect('/admin/products');
                }
            } else if ($request->hasFile('product_video')) {

                $file = $request->file('product_video');
                if ($file->isValid()) {
                    $filename = rand(100, 1000000000000) . '.' . $file->getClientOriginalExtension();
                    $path = public_path('/upload');
                    $file->move($path, $filename);
                    $data['product_video'] = $filename;
                    $product->update($data);
                    Session::flash('success_message', 'Your product has been updated');
                    return redirect('/admin/products');
                }
            } else {
                // $data['category_image']=$data['category_image'];
                $product->update($data);
                Session::flash('success_message', 'Your product has been updated');
                return redirect('/admin/products');
            }
        }
        return View('admin.products.edit_product', compact('getsection', 'categories', 'product', 'arrays', 'brands'));
    }
    public function appendcategorieslevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $getcategories = Category::with('subcategories')->where(['section_id' => $data['section_id'], 'parent_id' => 0])->get();
            return View('admin.products.append_categories', compact('getcategories'));
        }
    }
    public function deleteproduct($id)
    {
        Product::find($id)->delete();
        return redirect()->back()->with('success_message', 'Product has been deleted');
    }
    public function deleteattributeproduct($product_id, $id)
    {
        $attr_pro = Attr_Product::where('product_id', $product_id)->find($id);
        $attr_pro->delete();
        return redirect()->back()->with('success_message', 'Attribute Product has been deleted');
    }
    public function addAttributes(Request $request, $id)
    {
        $product = Product::find($id);
        $attributes = Attr_Product::where('product_id', $id)->get();
        $request->validate(
            [
                'sku' => 'unique:product_attributes,sku'
            ]
        );
        // dd($productdata->product);
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            // $data['status']=1;
            foreach ($data['sku'] as $key => $value) {
                $attr = new Attr_Product();
                $attr->product_id = $id;
                $attr->sku = $data['sku'][$key];
                $attr->size = $data['size'][$key];
                $attr->price = $data['price'][$key];
                $attr->stock = $data['stock'][$key];
                $attr->status = 1;
                $attr->save();
            }
            return redirect()->back()->with('success_message', 'Attribute Product has been deleted');
        }

        return View('admin.products.add_attributes', compact('product', 'attributes'));
    }
    public function editattributeproduct(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Attr_Product::find($id)->update(['price' => $data['price'], 'stock' => $data['stock']]);
            return redirect()->back()->with('success_message', 'Attribute Product has been updated');
        }
    }
    public function updateattrstatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Attr_Product::where('id', $data['attr_id'])->update(['status' => $status]);
            return response()->json(['status' => $data['status']]);
        }
    }
    public function addimages(Request $request, $id)
    {
        $product = Product::find($id);
        $pros_imgs = Products_Images::where('product_id', $id)->get();
        // dd($pros_imgs);

        if ($request->isMethod('post')) {
            // $request->validate(
            //     [
            //         'image' => 'mimes:png,jpg'
            //     ]
            // );
            $data = $request->all();

            // dd($request->file('fileimage'));
            if ($request->hasFile('image')) {
                // echo "<pre></pre>"; dd($request->file('fileimage')); die;
                foreach ($request->file('image') as $key => $img) {
                    $reimage = rand(100, 10000000) . '.' . $img->getClientOriginalExtension();
                    $dest = public_path('/imgs');

                    $img->move($dest, $reimage);
                    $pro_img = new Products_Images();
                    $pro_img->product_id = $id;
                    $pro_img->status = 1;
                    $pro_img->image = $reimage;
                    $pro_img->save();
                }
            }
            return redirect()->back()->with('success_message', 'Image Product has been created');
        }
        return View('admin.products.add_images', compact('product', 'pros_imgs'));
    }
    public function deleteattributeimage(Request $request, $product_id, $id)
    {
        $pro_img = Products_Images::where('product_id', $product_id)->find($id);
        $pro_img->delete();
        return redirect()->back()->with('success_message', 'Image Product has been deleted');
    }
    public function editattributeimage(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Products_Images::find($id)->update([]);
        }
    }
    public function updateproductimagestatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Products_Images::where('id', $data['img_id'])->update(['status' => $status]);
            return response()->json(['status' => $data['status']]);
        }
    }
    public function showvideo($id)
    {
        $product = Product::find($id);
        // dd($product->product_video);
        return View('admin.products.showvideo', compact('product'));
    }
    public function editimageproduct(Request $request, $id)
    {
        $pro_img = Products_Images::find($id);
        $data = $request->all();
        // dd($data);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // dd($image);
            $filename = rand(100, 1000000000000) . '.' . $image->getClientOriginalExtension();
            $path = public_path('/imgs');
            $image->move($path, $filename);
            $data['image'] = $filename;
            // $data['status']=(($data['status']==1)?1:0);
            $pro_img->update($data);
            return redirect()->back()->with('success_message', 'Product Image has been updated');
        } else {
            $data['image'] = $pro_img->image;
            $pro_img->update($data);
            return redirect()->back()->with('success_message', 'Product Image has been updated');
        }
    }
}
