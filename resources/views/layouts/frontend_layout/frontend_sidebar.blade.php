<?php
use App\Models\Sections;
use App\Models\User;
$sections=Sections::sections();
?>

<div id="sidebar" class="span3">
    @if(Auth::check())
    <div class="well well-small"><a id="myCart" href="{{url('/cart')}}"><img
                src="frontend/images/ico-cart.png" alt="cart">{{User::countquantity()}} Items in your cart</a></div>
    @endif
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach($sections as $section)
        @if(count($section->categories()->get())>0)
        <li class="subMenu"><a>{{$section->name}}</a>
            @foreach($section->categories()->get() as $category)
            <ul>

                <li><a href="{{url($category['url'])}}"><i class="icon-chevron-right"></i><strong>{{$category->category_name}}</strong></a>
                </li>
                @foreach($category->subcategories()->get() as $subcategory)
                <li><a href="{{url($subcategory['url'])}}"><i class="icon-chevron-right"></i>{{$subcategory->category_name}}</a></li>

                @endforeach

            </ul>
            @endforeach
        </li>
        @endif
        @endforeach
    </ul>
    <br />
    <div class="thumbnail">
        <img src="frontend/images/payment_methods.png" title="Payment Methods" alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>


