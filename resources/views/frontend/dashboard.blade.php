@extends('layouts.frontend_layout.frontend_layout')
@section('content')

    <div class="span9">
        <div class="well well-small">
            @if ($featuredItemsCount > 0)
            <h4>Featured Products <small class="pull-right">{{ $featuredItemsCount }} featured products</small></h4>
            <div class="row-fluid">
                <div id="featured" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($featuredChunk as $key => $featuredItem)

                                <div class="item @if ($key==1) active @endif">
                                    <ul class="thumbnails">
                                        @foreach ($featuredItem as $item)
                                            <li class="span3">
                                                <div class="thumbnail">
                                                    <i class="tag"></i>
                                                    <a href="{{url('/product', $item['id'])}}">
                                                        @if (isset($item['main_image']))
                                                            <img src="imgs/{{ $item['main_image'] }}" alt="">
                                                        @else
                                                            <img src="imgs/noimage.png" alt="">
                                                        @endif
                                                    </a>
                                                    <div class="caption">
                                                        <h5>{{ $item['product_name'] }}</h5>
                                                        <h4><a class="btn" href="{{url('/product', $item['id'])}}">VIEW</a> <span
                                                                class="pull-right">
                                                                @if($item['product_discount']==0)Rs.{{ $item['product_price'] }}
                                                                @else Rs.{{(100-$item['product_discount'])/100*$item['product_price']}}
                                                                @endif
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                </div>
                @endif
            </div>
        </div>
        <h4>Latest Products </h4>
        <ul class="thumbnails">
            @foreach ($newProducts as $new)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="{{url('/product', $new['id'])}}">
                            @if (isset($new['main_image']))
                                <img src="imgs/{{ $new['main_image'] }}" style="width: 250px; height:250px" alt="">
                            @else
                                <img src="imgs/noimage.png" style="width: 250px; height:250px" alt="">
                            @endif
                        </a>
                        <div class="caption">
                            <h5>{{ $new['product_name'] }}</h5>
                            <p>
                                {{ $new['product_code'] }} ({{ $new['product_color'] }})
                            </p>

                            <h4 style="text-align:center"><a class="btn" href="{{url('/product', $new['id'])}}"> <i
                                        class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i
                                        class="icon-shopping-cart"></i></a> <a class="btn btn-primary"
                                    href="#">@if($new['product_discount']==0)Rs.{{ $new['product_price'] }}
                                    @else  Rs.{{(100-$new['product_discount'])/100*$new['product_price']}}
                                    @endif</a></h4>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>

    </div>

@endsection
