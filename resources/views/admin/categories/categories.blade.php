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
                            <li class="breadcrumb-item active">DataTables</li>
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
                                <h3 class="card-title">Categories</h3>
                                <a href="{{ url('/admin/add-category') }}" role="button"
                                    style="max-width: 150px;float:right" class="btn btn-block btn-success">Add
                                    Category</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Parent Category</th>
                                            <th>Section</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th style="width:100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{ $i = 1 }}"> --}}
                                        @foreach ($categories as $i=>$category)
                                            @if (!isset($category->parentcategory->category_name))
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $category->category_name }}</td>

                                                    <td>{{ 'Root' }}</td>
                                                    <td>{{ $category->section->name }}</td>

                                                    <td>{{ $category->url }}</td>
                                                    <td>
                                                        @if ($category->status == 1)
                                                            <a class="updatecategorystatus text text-success"
                                                                category_id="{{ $category->id }}"
                                                                id="category-{{ $category->id }}"
                                                                href="javascript:void(0)">Active</a>
                                                        @else
                                                            <a class="updatecategorystatus text text-danger"
                                                                category_id="{{ $category->id }}"
                                                                id="category-{{ $category->id }}"
                                                                href="javascript:void(0)">Inactive
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/admin/edit-category', $category->id) }}"
                                                            class="" style="font-size: 20px"><i class="fas fa-edit" style="color: green"></i></a>
                                                            &nbsp;&nbsp;
                                                        <a href="javascript:void(0)" record='category' recordid={{$category->id}}
                                                            class="confirmdelete" style="font-size: 20px"><i
                                                                class="fa fa-trash-alt" style="color: red"></i></a>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $category->category_name }}</td>
                                                    <td>{{ $category->parentcategory->category_name }}</td>
                                                    <td>{{ $category->section->name }}</td>
                                                    <td>{{ $category->url }}</td>
                                                    <td>
                                                        @if ($category->status == 1)
                                                            <a class="updatecategorystatus text text-success"
                                                                category_id="{{ $category->id }}"
                                                                id="category-{{ $category->id }}"
                                                                href="javascript:void(0)">Active</a>
                                                        @else
                                                            <a class="updatecategorystatus text text-danger"
                                                                category_id="{{ $category->id }}"
                                                                id="category-{{ $category->id }}"
                                                                href="javascript:void(0)">Inactive
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('/admin/edit-category', $category->id) }}" style="font-size: 20px; color:green"><i class="fas fa-edit"></i></a>
                                                            &nbsp;&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" record='category' recordid={{$category->id}}
                                                            class="confirmdelete" style="font-size: 20px; color:red"><i
                                                                class="fa fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
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
