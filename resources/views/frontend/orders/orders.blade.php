@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <!-- Sidebar end=============================================== -->
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li class="active">Orders</li>
        </ul>
        <h3> Orders</h3>
        <hr class="soft" />
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
        <div class="row">
            <div class="span9">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Products</th>
                        <th>Grand Total</th>
                        <th>Created on</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $order)
                    <tr>

                            <td>{{$order['id']}}</td>
                            <td>
                                @foreach ($order['order_product'] as $pro)
                                    {{$pro['product_code']}},&nbsp;{{$pro['product_name']}},&nbsp;{{$pro['product_size']}}<br>
                                @endforeach
                            </td>
                            <td>{{$order['grand_total']}}</td>
                            <td>{{date('d-m-Y', strtotime($order['created_at']))}}</td>
                            <td>@if ($order['check_order'][0]['status']==0)
                                <span style="color:red">UNACCEPT</span>
                                @else <span style="color:green">ACCEPT</span>
                            @endif</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>

    </div>
@endsection
