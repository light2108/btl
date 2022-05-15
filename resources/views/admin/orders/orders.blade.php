@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('success_message') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User_Order</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User_Order</h3>
                                <!-- Sidebar end=============================================== -->

                            </div>
                            <!-- /.card -->
                            <div class="card-body">
                                <table id="users-orders" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Username</th>
                                                    <th>Mobiphone</th>
                                                    <th>Address</th>
                                                    <th>Order Products</th>
                                                    <th>Grand Total</th>
                                                    <th>Created on</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                                @foreach ($orders as $order)
                                                <tr>

                                                        <td>{{$order['id']}}</td>
                                                        <td>{{$order['name']}}</td>
                                                        <td>{{$order['mobile']}}</td>
                                                        <td>{{$order['address']}}</td>
                                                        <td>
                                                            @foreach ($order['order_product'] as $pro)
                                                                {{$pro['product_code']}},&nbsp;{{$pro['product_name']}},&nbsp;{{$pro['product_size']}}<br>
                                                            @endforeach
                                                        </td>
                                                        <td>{{$order['grand_total']}}</td>
                                                        <td>{{date('d-m-Y', strtotime($order['created_at']))}}</td>
                                                        <td>
                                                        @if($order['check_order'][0]['status']==0)
                                                        <form method="post" action="{{url('/admin/check-order', $order['id'])}}">
                                                            @csrf
                                                            <button type="submit">

                                                                <span style="color:red">Unconfirmed</span>

                                                            </button>
                                                        </form>
                                                        @else <span style="color:green">Confirmed</span>
                                                        @endif
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>

                                </table>
                            </div>

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
