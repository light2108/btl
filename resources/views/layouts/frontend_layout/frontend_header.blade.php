<?php
use App\Models\Sections;
use App\Models\User;
$sections=Sections::sections();
?>
<div id="header">
	<div class="container">
		<div id="welcomeLine" class="row">
            @if(Auth::check())
			<div class="span6">Welcome!<strong> {{Auth::user()->name}}</strong></div>

			<div class="span6">
				<div class="pull-right">
					<a href="{{url('/cart')}}"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ {{User::countquantity()}} ] Items in your cart </span> </a>
				</div>
			</div>
            @endif
		</div>
		<!-- Navbar ================================================== -->
		<section id="navbar">
		  <div class="navbar">
		    <div class="navbar-inner">
		      <div class="container">
		        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		        </a>
		        <a class="brand" href="#">Stack Developers</a>
		        <div class="nav-collapse">
		          <ul class="nav">
		            <li class="active"><a href="#">Home</a></li>
                    @foreach($sections as $section)
                        @if(count($section->categories()->get())>0)
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$section->name}} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                    @foreach($section->categories()->get() as $category)
                                        <li class="divider"></li>
                                        <li class="nav-header"><a href="{{$category->url}}">{{$category->category_name}}</a></li>
                                            @foreach($category->subcategories()->get() as $subcategory)
                                                <li><a href="{{$subcategory->url}}">&nbsp;&nbsp;&raquo;&nbsp;{{$subcategory->category_name}}</a></li>

                                            @endforeach
                                    @endforeach
                            </ul>
                            </li>
                        @endif
                    @endforeach

		            <li><a href="{{url('/contact-us')}}">Contact</a></li>
		          </ul>
		          <form class="navbar-search pull-left" action="">

		            <input type="text" class="search-query span2" name="search" placeholder="Search"/>
		          </form>
		          <ul class="nav pull-right">
                      {{-- <?php dd(Session::get('order_id')); ?> --}}
                    @if(Auth::check()&&Session::get('check')==1)

		            <li><a href="{{url('/order')}}">Order</a></li>
                    @endif
		            <li class="divider-vertical"></li>
                    @if(Auth::check())
		            <li><a href="{{url('/account')}}">Account: {{Auth::user()->name}}</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{url('/logout')}}">Logout</a></li>
                    @else
                    <li><a href="{{url('/login-register')}}">Login/Register</a></li>
                    @endif
		          </ul>
		        </div><!-- /.nav-collapse -->
		      </div>
		    </div><!-- /navbar-inner -->
		  </div><!-- /navbar -->
		</section>
	</div>
</div>
