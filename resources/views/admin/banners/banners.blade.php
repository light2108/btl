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
                            <li class="breadcrumb-item active">Banners</li>
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
                                <h3 class="card-title">Banners</h3>

                                <a role="button" style="max-width: 150px;float:right" class="btn btn-block btn-success"
                                    data-toggle="modal" data-target="#exampleModal">Add Banners</a>
                                <form action="{{ url('/admin/add-banner') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add New Banner</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="recipient-name"
                                                                class="col-form-label">Title:</label>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="title" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name"
                                                                class="col-form-label">Image:</label>
                                                            <input type="file" class="form-control" id="recipient-name"
                                                                name="image" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Link:</label>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="link" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Alt:</label>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="alt">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Status:</label>
                                                            <input class="active" type="checkbox" value="1" checked
                                                                name="status">Active
                                                            <input class="inactive" type="checkbox" value="0"
                                                                name="status">Inactive
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Create Banner</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="banners" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th style="width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <input type="hidden" value="{{$i=1}}"> --}}
                                        @foreach ($banners as $i => $banner)
                                            <tr>


                                                <td>{{ ++$i }}</td>
                                                <td>{{ $banner->title }}
                                                </td>
                                                <td><img src="imgs/{{ $banner->image }}" style="width: 400px; height:200px">
                                                </td>
                                                <td>
                                                    @if ($banner->status == 1)
                                                        <a class="updatebannerstatus text text-success"
                                                            banner_id="{{ $banner->id }}" id="banner-{{ $banner->id }}"
                                                            href="javascript:void(0)">Active</a>
                                                    @else
                                                        <a class="updatebannerstatus text text-danger"
                                                            banner_id="{{ $banner->id }}" id="banner-{{ $banner->id }}"
                                                            href="javascript:void(0)">Inactive
                                                    @endif
                                                </td>

                                                </td>
                                                <td>
                                                    <form action="{{ url('/admin/edit-banner', $banner->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal fade" id="exampleModalx{{ $banner->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                            Brand</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name"
                                                                                    class="col-form-label">Title:</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="recipient-name" name="title"
                                                                                    value="{{ $banner->title }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name"
                                                                                    class="col-form-label">Image:</label>
                                                                                <div class="input-group">
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                            class="custom-file-input"
                                                                                            name="image"
                                                                                            id="exampleInputFile">
                                                                                        <label class="custom-file-label"
                                                                                            for="exampleInputFile">{{ $banner->image }}</label>
                                                                                    </div>
                                                                                    <div class="input-group-append">
                                                                                        <span
                                                                                            class="input-group-text">Upload</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <img src="imgs/{{ $banner->image }}"
                                                                                    style="width: 200px; height:100px">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name"
                                                                                    class="col-form-label">Link:</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="recipient-name" name="link" readonly
                                                                                    value="{{ $banner->link }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name"
                                                                                    class="col-form-label">Alt:</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="recipient-name" name="alt"
                                                                                    value="{{ $banner->alt }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="message-text"
                                                                                    class="col-form-label">Status:</label>
                                                                                @if ($banner->status == 1)
                                                                                    <input class="active" type="checkbox"
                                                                                        value="1" checked
                                                                                        name="status">Active
                                                                                    <input class="inactive" type="checkbox"
                                                                                        value="0" name="status">Inactive
                                                                                @else
                                                                                    <input class="active" type="checkbox"
                                                                                        value="1" name="status">Active
                                                                                    <input class="inactive" type="checkbox"
                                                                                        checked value="0"
                                                                                        name="status">Inactive
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update
                                                                            Banner</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <a title="Edit Banner" role="button" type="submit"><i
                                                            class="fas fa-edit" data-toggle="modal"
                                                            data-target="#exampleModalx{{ $banner->id }}"
                                                            style="color: green; font-size:25px"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a title="Delete Banner" href="javascript:void(0)" record='banner'
                                                        recordid={{ $banner->id }} class="confirmdelete"><i
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
