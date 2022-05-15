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
                            <li class="breadcrumb-item active">coupons</li>
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
                                <h3 class="card-title">Coupons</h3>

                                <a href="{{url('admin/add-coupon')}}" role="button" style="max-width: 150px;float:right" class="btn btn-block btn-success"
                                    >Add coupons</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="coupons" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th>Coupon Type</th>
                                            <th>Amount</th>
                                            <th>Expiry Date</th>
                                            <th>Status</th>
                                            <th style="width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{$i=1}}"> --}}
                                        @foreach ($coupons as $i => $coupon)
                                            <tr>


                                                <td>{{ ++$i }}</td>
                                                <td>{{ $coupon['coupon_code'] }}
                                                </td>
                                                <td>{{ $coupon['coupon_type'] }}
                                                </td>
                                                @if($coupon['amount_type']=="Percentage")
                                                <td>{{ $coupon['amount']}}&nbsp;%</td>
                                                @else
                                                <td>{{ $coupon['amount']}}&nbsp;VND</td>
                                                @endif
                                                <td>{{ $coupon['expiry_date'] }}</td>
                                                <td>
                                                    @if ($coupon['status'] == 1)
                                                        <a class="updatecouponstatus text text-success"
                                                            coupon_id="{{ $coupon['id'] }}"
                                                            id="coupon-{{ $coupon['id'] }}"
                                                            href="javascript:void(0)">Active</a>
                                                    @else
                                                        <a class="updatecouponstatus text text-danger"
                                                            coupon_id="{{ $coupon['id'] }}"
                                                            id="coupon-{{ $coupon['id'] }}"
                                                            href="javascript:void(0)">Inactive
                                                    @endif
                                                </td>

                                                </td>
                                                <td>


                                                    <a href="{{url('/admin/edit-coupon', $coupon['id'])}}" title="Edit coupon" role="button" type="submit"><i
                                                            class="fas fa-edit"
                                                            style="color: green; font-size:25px"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a title="Delete coupon" href="javascript:void(0)" record='coupon'
                                                        recordid={{ $coupon['id'] }} class="confirmdelete"><i
                                                            class="fa fa-trash-alt"
                                                            style="color: red;font-size:25px"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


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
