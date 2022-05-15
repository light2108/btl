@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="form-group">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Video</label><br>
                    <video height="500px" preload="auto" controls>
                        <source src="upload/{{ $product->product_video }}" type="video/mp4">
                    </video>

                </div>
            </div>

        </div>
    </div>
@endsection
