@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <!-- Sidebar end=============================================== -->
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li class="active">Login</li>
        </ul>
        <h3> Login</h3>
        <hr class="soft" />

        <div class="row">
            <div class="span4">
                @if (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('success_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ Session::get('error_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="well">
                    <h5>Your profile account</h5><br />
                    Detail an account.<br /><br /><br />
                    <form action="{{ url('/update-account') }}" method="POST">
                        @csrf
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Name</label>
                            <div class="controls">
                                <input class="span3" name="name" value="{{$account['name']}}" type="text" id="inputEmail0" required placeholder="Name">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Mobile</label>
                            <div class="controls">
                                <input class="span3" name="mobile" value="{{$account['mobile']}}" type="tel" id="inputEmail0" required placeholder="Mobile">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">E-mail address</label>
                            <div class="controls">
                                <input class="span3" name="email" value="{{$account['email']}}" type="email" required id="inputEmail0" placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Address</label>
                            <div class="controls">
                                <input class="span3" name="address" value="{{$account['address']}}" type="text" required id="inputEmail0" placeholder="Address">
                            </div>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn block">Update Your Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span1"> &nbsp;</div>
            <div class="span4">
                @if (Session::has('successx_message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('successx_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::has('errorx_message'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ Session::get('errorx_message') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="well">
                    <h5>Update your password</h5>
                    <form action="{{url('/update-password-account')}}" method="POST">
                        @csrf

                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Password</label>
                            <div class="controls">
                                <input type="password" name="password" required class="span3" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Confirm Password</label>
                            <div class="controls">
                                <input type="password" name="confirm_password" required class="span3" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">New Password</label>
                            <div class="controls">
                                <input type="password" name="new_password" required class="span3" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Update your password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
