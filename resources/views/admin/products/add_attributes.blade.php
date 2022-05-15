@extends('layouts.admin_layout.admin_layout')
@section('content')

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
                            <li class="breadcrumb-item active">Add Attributes</li>

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
        <form action="{{ url('/admin/attr-product', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Attributes</h3>

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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Name:
                                                {{ $product->product_name }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Code:
                                                {{ $product->product_code }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Color:
                                                {{ $product->product_color }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Price:
                                                {{ $product->product_price }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Main Image</label><br>
                                            @if (isset( $product->main_image))
                                                <img src="imgs/{{  $product->main_image }}" width="150px"
                                                    style="margin-top: 5px">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body newRow">
                            {{-- <input type="hidden" name="product_id[]" value="{{$attribute->id}}"> --}}
                            <div class="row ">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Size</label><br>
                                            {{-- <input type="text" name="size[]" class="form-control" required> --}}
                                            <select name="size[]" class="form-control" required>
                                                <option>Small</option>
                                                <option>Medium</option>
                                                <option>Big</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Price</label><br>
                                            <input type="number" name="price[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Stock</label><br>
                                            <input type="number" name="stock[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">SKU</label><br>
                                            <input type="text" name="sku[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="add-attr"><i class="fa fa-plus-circle"
                                                    style="font-size: 30px; margin-top:35px"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Added Product Attributes</h3>
            </div>
            <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Size</th>

                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <td style="width:120px">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                        @foreach ($attributes as $i => $attribute)

                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $attribute->size }}</td>
                                <td>{{ $attribute->sku }}</td>
                                <form id="update_attribute" action="{{ url('/admin/edit-attribute-product', $attribute->id) }}"
                                    method="POST">
                                    @csrf
                                    <td><input type="number" name="price" required value="{{ $attribute->price }}"></td>


                                    <td><input type="number" name="stock" required value="{{ $attribute->stock }}"></td>
                                    <td>
                                        @if ($attribute->status == 1)
                                            <a class="updateattributestatus text text-success"
                                                attr_id="{{ $attribute->id }}" id="attr-{{ $attribute->id }}"
                                                href="javascript:void(0)">Active</a>
                                        @else
                                            <a class="updateattributestatus text text-danger"
                                                attr_id="{{ $attribute->id }}" id="attr-{{ $attribute->id }}"
                                                href="javascript:void(0)">Inactive</a>
                                        @endif
                                    </td>
                                    <td>

                                        <a title="Edit Attribute Product" style="font-size: 20px"><button type="submit"><i
                                                    class="fas fa-edit" style="color: green"></i></button></a>
                                        &nbsp;&nbsp;
                                        <a title="Delete Attribute Product" href="{{route('delete.attribute.product', ['product_id'=>$attribute->product_id, 'id'=>$attribute->id])}}" style="font-size: 20px"><i
                                                class="fas fa-trash-alt" style="color: red"></i></a>
                                    </td>
                                </form>
                            </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <!-- SELECT2 EXAMPLE -->
    </div>


    <!-- /.container-fluid -->

@endsection
