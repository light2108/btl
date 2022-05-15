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
                            <li class="breadcrumb-item active">Add Images</li>

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
        <form action="{{ url('/admin/add-images', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Images</h3>

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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Main Image</label><br>
                                            @if (isset($product->main_image))
                                                <img src="imgs/{{ $product->main_image }}" width="150px"
                                                    style="margin-top: 5px">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body newImages">
                            {{-- <input type="hidden" name="product_id[]" value="{{$pro_img->id}}"> --}}
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chosen Image</label><br>
                                            <input type="file" name="image[]" multiple class="form-control" required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Image</button>
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
                            <th>Image</th>
                            <th>Status</th>
                            <td style="width:120px">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                        @foreach ($pros_imgs as $i => $pro_img)

                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><img src="/imgs/{{ $pro_img->image }}" width="200" height="200"></td>
                                <td>
                                    @if ($pro_img->status == 1)
                                        <a class="updateproductimagestatus text text-success" img_id="{{ $pro_img->id }}"
                                            id="img-{{ $pro_img->id }}" href="javascript:void(0)">Active</a>
                                    @else
                                        <a class="updateproductimagestatus text text-danger" img_id="{{ $pro_img->id }}"
                                            id="img-{{ $pro_img->id }}" href="javascript:void(0)">Inactive</a>
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ url('admin/edit-image-product', $pro_img->id) }}" method="POST">
                                        @csrf
                                        <div class="modal fade" id="exampleModal{{ $pro_img->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Image Product
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">Image:</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            name="image" id="exampleInputFile">
                                                                        <label class="custom-file-label"
                                                                            for="exampleInputFile">{{ $pro_img->image }}</label>
                                                                    </div>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <img src="imgs/{{ $pro_img->image }}"
                                                                    style="width: 200px; height:200px">
                                                            </div>
                                                            @if ($pro_img->status == 1)
                                                                <div class="form-group">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Status:</label>
                                                                    <input class="active" type="checkbox" value="1" checked
                                                                        name="status">Active
                                                                    <input class="inactive" type="checkbox" value="0"
                                                                        name="status">Inactive
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Status:</label>
                                                                    <input class="active" type="checkbox" value="1"
                                                                        name="status">Active
                                                                    <input class="inactive" type="checkbox" value="0"
                                                                        name="status" checked>Inactive
                                                                </div>
                                                            @endif

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update Image
                                                            Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a title="Edit Image Product" role="button" type="submit" style="font-size: 20px"><i
                                                class="fas fa-edit" style="color: green" data-toggle="modal"
                                                data-target="#exampleModal{{ $pro_img->id }}"></i></a>
                                        &nbsp;&nbsp;
                                        <a title="Delete Image Product" href="{{route('delete.attribute.image', ['product_id'=>$pro_img->product_id, 'id'=>$pro_img->id])}}" style="font-size: 20px"><i
                                                class="fas fa-trash-alt" style="color: red"></i></a>
                                    </form>
                                </td>


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
