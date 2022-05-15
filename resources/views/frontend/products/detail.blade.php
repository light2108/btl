<?php use App\Models\Product; ?>
@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
            <li><a
                    href="{{ url('/', $productDetail['category']['url']) }}">{{ $productDetail['category']['category_name'] }}</a>
                <span class="divider">/</span>
            </li>
            <li class="active">product Details</li>
        </ul>
        <div class="row">
            <div id="gallery" class="span3">
                <a href="imgs/{{ $productDetail['main_image'] }}" title="{{ $productDetail['product_name'] }}">
                    <img src="imgs/{{ $productDetail['main_image'] }}" style="width:260px; height:300px"
                        alt="{{ $productDetail['product_name'] }}" />
                </a>
                <div id="differentview" class="moreOptopm carousel slide">
                    <div class="carousel-inner">
                        <div class="item active">
                            @foreach ($productDetail['images'] as $image)
                                <a href="imgs/{{ $image['image'] }}"> <img style="width:29%; height:80px"
                                        src="imgs/{{ $image['image'] }}" alt="" /></a>
                            @endforeach
                        </div>
                        <div class="item">
                            @foreach ($productDetail['images'] as $image)
                                <a href="imgs/{{ $image['image'] }}"> <img style="width:29%; height:80px"
                                        src="imgs/{{ $image['image'] }}" alt="" /></a>
                            @endforeach
                        </div>
                    </div>
                    <!--
                                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                            -->
                </div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <span class="btn"><i class="icon-envelope"></i></span>
                        <span class="btn"><i class="icon-print"></i></span>
                        <span class="btn"><i class="icon-zoom-in"></i></span>
                        <span class="btn"><i class="icon-star"></i></span>
                        <span class="btn"><i class=" icon-thumbs-up"></i></span>
                        <span class="btn"><i class="icon-thumbs-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="span6">
                @if (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('success_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ Session::get('error_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <h3>{{ $productDetail['product_name'] }} </h3>
                <small>- {{ $productDetail['brand']['name'] }} </small>
                <hr class="soft" />
                <small>{{ $total_stock }} items in stock</small>
                <form action="{{ url('/add-to-cart') }}" method="POST" class="form-horizontal qtyFrm">
                    @csrf
                    <input type="hidden" value="{{ $productDetail['id'] }}" name="product_id">
                    <div class="control-group">
                        <?php $discount_price = Product::getDiscountPrice($productDetail['id']); ?>
                        <h4 class="getAttrPrice">
                            @if ($discount_price > 0)
                                <del>Rs.{{ $productDetail['product_price'] }}</del>
                                &nbsp;(-{{ $productDetail['product_discount'] }}%)
                                &nbsp;Rs.{{ $discount_price }}
                            @else Rs.{{ $productDetail['product_price'] }}
                            @endif
                        </h4>

                        <select id="getPrice" name="size" required product-id={{ $productDetail['id'] }}
                            class="span2 pull-left">
                            <option selected value="">Select Size</option>
                            @foreach ($productDetail['attributes'] as $attribute)
                                <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="quantity" min="0" value="0" class="span1" placeholder="Qty." />
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i
                                class=" icon-shopping-cart"></i></button>
                    </div>
                </form>
            </div>


            <hr class="soft clr" />
            <p class="span6">
                {{ $productDetail['description'] }}

            </p>
            <a class="btn btn-small pull-right" href="#detail">More Details</a>
            <br class="clr" />
            <a href="#" name="detail"></a>
            <hr class="soft" />
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                <li><a href="#profile" data-toggle="tab">Related Products</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow">
                                <th colspan="2">Product Details</th>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Brand: </td>
                                <td class="techSpecTD2">{{ $productDetail['brand']['name'] }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Code:</td>
                                <td class="techSpecTD2">{{ $productDetail['product_code'] }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Color:</td>
                                <td class="techSpecTD2">{{ $productDetail['product_color'] }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Fabric:</td>
                                <td class="techSpecTD2">{{ $productDetail['fabric'] }}</td>
                            </tr>
                            @if (isset($productDetail['pattern']))
                                <tr class="techSpecRow">
                                    <td class="techSpecTD1">Pattern:</td>
                                    <td class="techSpecTD2">{{ $productDetail['pattern'] }}</td>
                                </tr>
                            @endif
                            @if (isset($productDetail['sleeve']))
                                <tr class="techSpecRow">
                                    <td class="techSpecTD1">Sleeve:</td>
                                    <td class="techSpecTD2">{{ $productDetail['sleeve'] }}</td>
                                </tr>
                            @endif
                            @if (isset($productDetail['fit']))
                                <tr class="techSpecRow">
                                    <td class="techSpecTD1">Fit:</td>
                                    <td class="techSpecTD2">{{ $productDetail['fit'] }}</td>
                                </tr>
                            @endif
                            @if (isset($productDetail['occassion']))
                                <tr class="techSpecRow">
                                    <td class="techSpecTD1">Occasion:</td>
                                    <td class="techSpecTD2">{{ $productDetail['occassion'] }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <h5>Washcare</h5>
                    <p>{{ $productDetail['wash_care'] }}</p>
                    <h5>Disclaimer</h5>
                    <p>
                        There may be a slight color variation between the image shown and original product.
                    </p>
                </div>
                <div class="tab-pane fade" id="profile">
                    <div id="myTab" class="pull-right">
                        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i
                                    class="icon-list"></i></span></a>
                        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i
                                    class="icon-th-large"></i></span></a>
                    </div>
                    <br class="clr" />
                    <hr class="soft" />
                    <div class="tab-content">
                        <div class="tab-pane" id="listView">
                            @foreach ($relatedProducts as $related)
                                <div class="row">
                                    <div class="span2">
                                        <img src="imgs/{{ $related['main_image'] }}" style="height: 200px" alt="" />
                                    </div>
                                    <div class="span4">
                                        <h3>{{ $related['product_name'] }}</h3>
                                        <hr class="soft" />
                                        <h5>{{ $related['product_code'] }} </h5>
                                        <p>
                                            {{ $related['description'] }}
                                        </p>
                                        <a class="btn btn-small pull-right"
                                            href="{{ url('/product', $related['id']) }}">View Details</a>
                                        <br class="clr" />
                                    </div>
                                    <div class="span3 alignR">
                                        <form class="form-horizontal qtyFrm">
                                            <h3> Rs.{{ $related['product_price'] }}</h3>
                                            <label class="checkbox">
                                                <input type="checkbox"> Adds product to compair
                                            </label><br />
                                            <div class="btn-group">
                                                <a href="{{ url('/product', $related['id']) }}"
                                                    class="btn btn-large btn-primary"> Add to <i
                                                        class=" icon-shopping-cart"></i></a>
                                                <a href="{{ url('/product', $related['id']) }}" class="btn btn-large"><i
                                                        class="icon-zoom-in"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr class="soft" />
                            @endforeach
                        </div>
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach ($relatedProducts as $related)
                                    <li class="span3">
                                        <div class="thumbnail">
                                            <a href="{{ url('/product', $related['id']) }}"><img
                                                    src="imgs/{{ $related['main_image'] }}" style="height:200px"
                                                    alt="" /></a>
                                            <div class="caption">
                                                <h5>{{ $related['product_name'] }}</h5>
                                                <p>
                                                    {{ $related['product_code'] }}
                                                </p>
                                                <?php $discount_price =
                                                Product::getDiscountPrice($related['id']); ?>
                                                <h4 style="text-align:center"><a class="btn"
                                                        href="{{ url('/product', $related['id']) }}"> <i
                                                            class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i
                                                            class="icon-shopping-cart"></i></a> <a class="btn btn-primary"
                                                        href="#">
                                                        @if ($discount_price > 0)
                                                            Rs.{{ $discount_price }}
                                                        @else
                                                            Rs.{{ $related['product_price'] }}
                                                        @endif
                                                    </a></h4>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <hr class="soft" />
                        </div>
                    </div>
                    <br class="clr">
                </div>
            </div>
        </div>
    </div>

@endsection
