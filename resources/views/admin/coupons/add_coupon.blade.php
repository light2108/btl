@extends('layouts.admin_layout.admin_layout')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form action="{{ url('/admin/add-coupon') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Coupon</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Coupon Option:</label><br>
                                        <input type="radio" name="coupon_option" value="Automatic"
                                            checked class="automatic">Automatic&nbsp;&nbsp;
                                        <input type="radio" name="coupon_option"
                                            value="Manual" class="manual">Manual
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Coupon Type:</label><br>
                                        <input type="radio" name="coupon_type" checked
                                            value="Multiple Times">Multiple Times&nbsp;&nbsp;
                                        <input type="radio" name="coupon_type" value="Single Times">Single
                                        Times
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Amount Type:</label><br>
                                        <input type="radio" name="amount_type" checked
                                            value="Percentage" id="percentage">Percentage(%)&nbsp;&nbsp;
                                        <input type="radio" name="amount_type" value="Fixed" id="fixed">Fixed(VND)
                                    </div>
                                </div>
                                <div class="col-6" style="display:none" id="coupon_code">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Coupon Code:</label>
                                        <input type="text" class="form-control"
                                            id="recipient-name" name="coupon_code">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Select Categories:</label>
                                        <select class="form-control categories"
                                            name="categories[]" multiple="multiple">

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Select Users:</label>
                                        <select class="form-control user" name="user[]"
                                            multiple="multiple">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->email }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6" id="amount">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Amount(%):</label>
                                        <input type="number" min="0" max="100"
                                            class="form-control" id="recipient-name"
                                            name="amount" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                            class="col-form-label">Expiry Date:</label>
                                        <input type="date" class="form-control"
                                            id="recipient-name" name="expiry_date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="message-text"
                                            class="col-form-label">Status:</label><br>
                                        <input class="active" type="checkbox" value="1" checked
                                            name="status">Active
                                        <input class="inactive" type="checkbox" value="0"
                                            name="status">Inactive
                                    </div>
                                </div>
                            </div>

                            <!-- /.row -->

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <!-- SELECT2 EXAMPLE -->
    </div>

@endsection
