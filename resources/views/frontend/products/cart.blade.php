<?php
use App\Models\Cart;
use App\Models\User;
?>
@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <!-- Sidebar end=============================================== -->
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active"> SHOPPING CART</li>
        </ul>
        <h3> SHOPPING CART [ <small>{{ User::countquantity() }} Item(s) </small>]<a href="{{ url('/') }}"
                class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
        <hr class="soft" />
        {{-- <table class="table table-bordered">
            <tr>
                <th> I AM ALREADY REGISTERED </th>
            </tr>
            <tr>
                <td>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputUsername">Username</label>
                            <div class="controls">
                                <input type="text" id="inputUsername" placeholder="Username">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Password</label>
                            <div class="controls">
                                <input type="password" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign in</button> OR <a href="register.html"
                                    class="btn">Register Now!</a>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <a href="forgetpass.html" style="text-decoration:underline">Forgot password
                                    ?</a>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table> --}}
        <div class="success_message">

        </div>
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
        <div id="AppendCartItems">
            @include('frontend.products.cart_items')
        </div>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>

                        <form id="ApplyVoucher" method="post" action="javascript:void(0)" class="form-horizontal" @if (Auth::check()) user="1" @endif>
                            @csrf

                            <div class="control-group">
                                <label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
                                <div class="controls">
                                    <input type="text" class="input-medium" name="voucher_code" id="voucher_code"
                                        placeholder="CODE"> <?php Session::put('couponCode', Session::get('couponCode')); ?>
                                    <button type="submit" class="btn add_voucher"> ADD </button>
                                </div>
                            </div>
                        </form>

                    </td>
                </tr>

            </tbody>
        </table>
        <form action="{{url('/order')}}" method="post">
            @csrf
            <a href="{{ url('/') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
            @if (!Auth::check())
                <a href="{{ url('/login-register') }}" class="btn btn-large pull-right">Place Order <i
                        class="icon-arrow-right"></i></a>
            @else
                <a href="javascript:void(0)" role="button" type="submit" class="btn btn-large pull-right placeorder">Place Order <i
                        class="icon-arrow-right"></i></a>
            @endif
        </form>
    </div>
@endsection
