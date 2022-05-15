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
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <!-- Main content -->
        <form action="{{ url('/admin/edit-coupon', $coupon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Edit Coupon</h3>

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
                                        <label for="recipient-name" class="col-form-label">Coupon Option:</label><br>
                                        @if ($coupon->coupon_option == 'Automatic')
                                            <input type="radio" name="coupon_option" value="Automatic" checked
                                                class="automatic">Automatic&nbsp;&nbsp;
                                            <input type="radio" name="coupon_option" value="Manual" class="manual">Manual
                                        @else
                                            <input type="radio" name="coupon_option" value="Automatic"
                                                class="automatic">Automatic&nbsp;&nbsp;
                                            <input type="radio" name="coupon_option" value="Manual" class="manual"
                                                checked>Manual
                                        @endif

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Coupon Type:</label><br>
                                        @if ($coupon->coupon_type == 'Multiple Times')
                                            <input type="radio" name="coupon_type" checked value="Multiple Times">Multiple
                                            Times&nbsp;&nbsp;
                                            <input type="radio" name="coupon_type" value="Single Times">Single
                                            Times
                                        @else
                                            <input type="radio" name="coupon_type" value="Multiple Times">Multiple
                                            Times&nbsp;&nbsp;
                                            <input type="radio" name="coupon_type" checked value="Single Times">Single
                                            Times
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Amount Type:</label><br>
                                        @if ($coupon->amount_type == 'Percentage')
                                            <input type="radio" name="amount_type" checked value="Percentage"
                                                id="percentage">Percentage(%)&nbsp;&nbsp;
                                            <input type="radio" name="amount_type" value="Fixed" id="fixed">Fixed(VND)
                                        @else
                                            <input type="radio" name="amount_type" value="Percentage"
                                                id="percentage">Percentage(%)&nbsp;&nbsp;
                                            <input type="radio" name="amount_type" checked value="Fixed"
                                                id="fixed">Fixed(VND)
                                        @endif
                                    </div>
                                </div>
                                {{-- @if ($coupon->coupon_option == 'Manual') --}}
                                    <div class="col-6" style="display: none" id="coupon_code">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Coupon Code:</label>
                                            <input type="text" class="form-control" id="recipient-name" name="coupon_code"
                                                required value="{{ $coupon->coupon_code }}">
                                        </div>
                                    </div>
                                {{-- @endif --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Select Categories:</label>
                                        <select class="form-control categories" name="categories[]" multiple="multiple">


                                            @foreach ($categories as $category)
                                                <?php $ok=0;?>
                                                @foreach ($cate as $cat)
                                                    @if ($cat == $category->id)
                                                    <?php $ok=1;?>
                                                      <option value="{{ $category->id }}" selected>
                                                            {{ $category->category_name }}</option>
                                                    @endif
                                                @endforeach
                                                @if($ok==0)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Select Users:</label>
                                        <select class="form-control user" name="user[]" multiple="multiple">

                                            @foreach ($users as $user)
                                            <?php $ok=0;?>
                                                @foreach ($use as $us)
                                                    @if ($us == $user->id)
                                                    <?php $ok=1;?>
                                                        <option value="{{ $user->id }}" selected>
                                                            {{ $user->email }}</option>

                                                    @endif
                                                @endforeach
                                                @if($ok==0)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->email }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($coupon->amount_type == 'Fixed')
                                    <div class="col-6" id="amount">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Amount(VND):</label>
                                            <input type="number" min="0" class="form-control" id="recipient-name"
                                                name="amount" value="{{ $coupon->amount }}" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-6" id="amount">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Amount(%):</label>
                                            <input type="number" min="0" max="100" class="form-control" id="recipient-name"
                                                name="amount" value="{{ $coupon->amount }}" required>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Expiry Date:</label>
                                        <input type="date" class="form-control" id="recipient-name" name="expiry_date"
                                            value="{{ $coupon->expiry_date }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Status:</label><br>
                                        @if ($coupon->status == 1)
                                            <input class="active" type="checkbox" value="1" checked name="status">Active
                                            <input class="inactive" type="checkbox" value="0" name="status">Inactive
                                        @else
                                            <input class="active" type="checkbox" value="1" name="status">Active
                                            <input class="inactive" type="checkbox" value="0" checked name="status">Inactive
                                        @endif
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
