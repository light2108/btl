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
                            <li class="breadcrumb-item active">Products</li>
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
        <form action="{{ url('/admin/edit-product', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Edit Product</h3>

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
                                            <label for="exampleInputEmail1">Product Name</label>
                                            <input type="text" placeholder="Enter Product Name" name="product_name"
                                                class="form-control" required value="{{ $product->product_name }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Sections</label>
                                        <select class="form-control select2" name="section_id" id="product_section_id"
                                            style="width: 100%;">
                                            {{-- <option selected="selected">Select</option> --}}

                                            @foreach ($getsection as $section)
                                                @if ($section->id == $product->section_id)
                                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @else
                                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="appendproductslevel">
                                    <div class="form-group">
                                        <label>Select Category Level</label>
                                        <select class="form-control select2" name="category_id" style="width: 100%;">
                                            @if ($product->category_id == 0)
                                                <option value="0" selected="selected">Main Category</option>
                                            @else
                                                @foreach ($categories as $cate)
                                                    @if ($cate->id == $product->category_id)
                                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Brand</label>
                                            <select class="form control select2" name="brand_id" style="width: 100%">
                                                @foreach ($brands as $brand)
                                                    @if($brand->id==$product->brand_id)
                                                        <option value="{{$brand->id}}" selected>{{$brand->name}}</option>
                                                    @else
                                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Code</label>
                                            <input type="text" placeholder="Enter Product Code" name="product_code"
                                                value="{{ $product->product_code }}" class="form-control" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Product Color</label>
                                            <input type="text" placeholder="Enter Product Color" name="product_color"
                                                class="form-control" required value="{{ $product->product_color }}">

                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                @if(isset($product->main_image))
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Product Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="main_image"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">{{$product->main_image}}</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <img src="imgs/{{$product->main_image}}" style="width: 100px; height:100px">

                                    </div>
                                </div>
                                @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Main Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="main_image"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Chosen file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Price</label>
                                        <input type="number" name="product_price" class="form-control"
                                            value="{{ $product->product_price }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Fabric</label>
                                        <select class="form-control fabric select2" name="fabric">
                                            <option selected>{{ $product->fabric }}</option>
                                            @foreach ($arrays as $ar)
                                                @if ($ar != $product->fabric)
                                                    <option>{{ $ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Discount (%)</label>
                                        <input type="number" placeholder="Enter Product Discount" name="product_discount"
                                            class="form-control" required value="{{$product->product_discount}}" min="0" max="100"
                                            value="{{ $product->product_discount }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        @if ($product->status == 1)
                                            <input type="checkbox" name="status" value="1" class="active" checked>Active
                                            <input type="checkbox" name="status" class="inactive" value="0">Inactive
                                        @else
                                            <input type="checkbox" name="status" value="1" class="active">Active
                                            <input type="checkbox" name="status" class="inactive" value="0" checked>Inactive
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Is Featured</label><br>
                                        @if ($product->is_featured == 'Yes')
                                            <input type="checkbox" name="is_featured" checked>
                                        @else
                                            <input type="checkbox" name="is_featured">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Wash care</label>
                                        <textarea placeholder="Enter wash care" name="wash_care"
                                            class="form-control">{{ $product->wash_care }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pattern</label>
                                        <input type="text" name="pattern" class="form-control" value="{{$product->pattern}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Video</label>
                                        <div class="input-group">
                                            @if(isset($product->product_video))
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">{{$product->product_video}}</label>
                                            </div>

                                            <div class="input-group-append">
                                                <span class="input-group-text"><a href="{{url('/admin/showvideo', $product->id)}}">Upload</a></span>
                                            </div>
                                            @else
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Chosen file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Description</label>
                                        <textarea placeholder="Enter Description" name="description"
                                            class="form-control">{{ $product->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta title</label>
                                        <textarea type="text" placeholder="Enter meta title" name="meta_title"
                                            class="form-control">{{ $product->meta_title }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea placeholder="Enter Meta Description" name="meta_description"
                                            class="form-control">{{ $product->meta_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <textarea placeholder="Enter Meta Keywords" name="meta_keywords"
                                            class="form-control">{{ $product->meta_keywords }}</textarea>
                                    </div>
                                </div>


                                <!-- /.col -->
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
