<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $page_name="index";
        $featuredItemsCount=Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems=Product::where('is_featured', 'Yes')->where('status', 1)->get()->toArray();
        // dd($featuredItems);
        $featuredChunk=array_chunk($featuredItems, 4);
        // dd($featuredChunk);
        $newProducts=Product::with('category')->orderBy('id', 'Desc')->where('status', 1)->limit(6)->get()->toArray();
        // dd($newProducts);
        return View('frontend.dashboard', compact('page_name', 'featuredChunk', 'newProducts', 'featuredItemsCount'));
    }
}
