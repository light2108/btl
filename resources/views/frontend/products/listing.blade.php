<?php use App\Models\Product; ?>
@extends('layouts.frontend_layout.frontend_layout')
@section('content')

    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $categoryDetails['breadcrumbs']; ?></li>
        </ul>
        <h3> {{ $categoryDetails['catDetails']['category_name'] }} <small class="pull-right">
                {{ count($categoryProducts) }}
                products are available </small></h3>
        <hr class="soft" />
        <p>
            {{ $categoryDetails['catDetails']['description'] }}
        </p>
        <hr class="soft" />
        <form id="sortProducts" name="sortProducts" class="form-horizontal span6">
            <div class="control-group">
                <label class="control-label alignL">Sort By </label>
                <select name="sort" id="sort">
                    <option value="">Select</option>
                    <option value="product_lastest">Lastest Products</option>
                    <option value="product_name_a_z">Product name A - Z</option>
                    <option value="product_name_z_a">Product name Z - A</option>
                    <option value="price_highest">Price Highest first</option>
                    <option value="price_lowest">Price Lowest first</option>
                </select>
            </div>
        </form>

        <div id="myTab" class="pull-right">
            <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
            <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i
                        class="icon-th-large"></i></span></a>
        </div>
        <br class="clr" />
        <div class="tab-content">
            <div class="tab-pane" id="listView">
                @foreach ($categoryProducts as $product)
                    <div class="row">
                        <div class="span2">
                            @if (isset($product['main_image']))
                                <img src="imgs/{{ $product['main_image'] }}" style="height: 180px" alt="" />
                            @else
                                <img src="imgs/noimage.png" style="height: 180px" alt="" />
                            @endif
                        </div>
                        <div class="span4">
                            <h3>{{ $product['product_name'] }}</h3>
                            <hr class="soft" />
                            <h5>{{ $product['product_code'] }}</h5>
                            <p>
                                {{ $product['description'] }}
                            </p>
                            <a class="btn btn-small pull-right" href="{{ url('/product', $product->id) }}">View
                                Details</a>
                            <br class="clr" />
                        </div>
                        <div class="span3 alignR">
                            <form class="form-horizontal qtyFrm">
                                <h3>
                                    @if ($product['product_discount'] == 0)
                                        Rs.{{ $product['product_price'] }}
                                    @else
                                        Rs.{{ ((100 - $product['product_discount']) / 100) * $product['product_price'] }}
                                    @endif
                                </h3>
                                <label class="checkbox">
                                    <input type="checkbox"> Adds product to compare
                                </label><br />

                                <a href="{{ url('/product', $product->id) }}" class="btn btn-large btn-primary"> Add to
                                    <i class=" icon-shopping-cart"></i></a>
                                <a href="{{ url('/product', $product->id) }}" class="btn btn-large"><i
                                        class="icon-zoom-in"></i></a>

                            </form>
                        </div>
                    </div>
                    <hr class="soft" />
                @endforeach
            </div>
            <div class="tab-pane  active" id="blockView">
                <ul class="thumbnails">
                    @foreach ($categoryProducts as $product)
                        <li class="span3">
                            <div class="thumbnail">
                                @if (isset($product['main_image']))
                                    <a href="{{ url('/product', $product->id) }}"><img
                                            src="imgs/{{ $product['main_image'] }}" style="height:200px" alt="" /></a>
                                @else
                                    <a href="{{ url('/product', $product->id) }}"><img src="imgs/noimage.png"
                                            style="height:200px" alt="" /></a>
                                @endif
                                <div class="caption">
                                    <h5>{{ $product['product_name'] }}</h5>
                                    <p>
                                        {{ $product['brand']['name'] }}
                                    </p>
                                    <?php $discount_price=Product::getDiscountPrice($product['id']) ?>
                                    <h4 style="text-align:center"><a class="btn"
                                            href="{{ url('/product', $product->id) }}"> <i class="icon-zoom-in"></i></a>
                                        <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a
                                            class="btn btn-primary" href="#">
                                            @if ($discount_price >0)
                                                Rs.{{ $discount_price }}
                                            @else
                                                Rs.{{ $product['product_price'] }}
                                            @endif
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr class="soft" />
            </div>
        </div>
        <a href="compare.html" class="btn btn-large pull-right">Compare Product</a>
        <div class="pagination">
            {{ $categoryProducts->links('pagination::bootstrap-4') }}
        </div>
        <br class="clr" />
    </div>

@endsection
