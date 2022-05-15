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
                            <li class="breadcrumb-item active">Categories</li>
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
        <form action="{{ url('/admin/edit-category', $category->id) }}" method="POST" enctype="multipart/form-data" id="form-edit-category">
            @csrf
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>

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
                                            <label for="exampleInputEmail1">Category Name</label>
                                            <input type="text" placeholder="Enter Category Name" name="category_name"
                                                class="form-control" value="{{ $category->category_name }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Sections</label>
                                        <select class="form-control select2" name="section_id" id="category_section_id"
                                            style="width: 100%;">
                                            {{-- <option selected="selected">Select</option> --}}
                                            @foreach ($getsection as $section)
                                                @if ($section->id == $category->section_id)
                                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @else
                                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div id="appendcategorieslevel" class="col-md-6">
                                    @include('admin.categories.append_categories')
                                </div> --}}
                                <div class="col-md-6" id="appendcategorieslevel">
                                    <div class="form-group">
                                        <label>Select Category Level</label>
                                        <select class="form-control select2" name="parent_id" style="width: 100%;">
                                            @if($category->parent_id==0)
                                                <option value="0" selected="selected">Main Category</option>
                                            @else
                                                @foreach($categories as $cate)
                                                    @if($cate->id==$category->parent_id)
                                                        <option value="{{$cate->id}}">{{$cate->category_name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Category Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="category_image"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">{{$category->category_image}}</label>
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
                                        @if(isset($category->category_image))
                                        <img id="output" data-id="{{$category->id}}" src="imgs/{{$category->category_image}}" style="width: 100px; height:100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category Discount</label>
                                        <input type="number" placeholder="Enter Category Discount" name="category_discount"
                                            class="form-control" value="{{ $category->category_discount }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category URL</label>
                                        <input type="text" readonly name="url" class="form-control"
                                            value="{{ $category->url }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea placeholder="Enter Description" name="description"
                                            class="form-control">{{ $category->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Meta title</label>
                                        <input type="text" placeholder="Enter meta title" name="meta_title"
                                            class="form-control" value="{{ $category->meta_title }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label><br>
                                        @if ($category->status == 1)
                                            <input type="checkbox" name="status" value="1" class="active" checked>Active
                                            <input type="checkbox" name="status" class="inactive" value="0">Inactive
                                        @else
                                            <input type="checkbox" name="status" value="1" class="active">Active
                                            <input type="checkbox" name="status" class="inactive" value="0" checked>Inactive
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea placeholder="Enter Meta Description" name="meta_description"
                                            class="form-control">{{ $category->meta_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <textarea placeholder="Enter Meta Keywords" name="meta_keywords"
                                            class="form-control">{{ $category->meta_keywords }}</textarea>
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
