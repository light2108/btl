@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <!-- Sidebar end=============================================== -->
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Login</li>
        </ul>
        <h3> Login</h3>
        <hr class="soft" />

        <div class="row">
            <div class="span4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
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
                    <h5>CREATE YOUR ACCOUNT</h5><br />
                    Enter your e-mail address to create an account.<br /><br /><br />
                    <form action="{{ url('/register') }}" method="POST">
                        @csrf
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Name</label>
                            <div class="controls">
                                <input class="span3" name="name" type="text" id="inputEmail0" required placeholder="Name">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Mobile</label>
                            <div class="controls">
                                <input class="span3" name="mobile" type="tel" id="inputEmail0" required
                                    placeholder="Mobile">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Address</label>
                            <div class="controls">
                                <input class="span3" name="address" type="text" id="inputEmail0" required
                                    placeholder="Address">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">E-mail address</label>
                            <div class="controls">
                                <input class="span3" name="email" type="email" required id="inputEmail0"
                                    placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputEmail0">Password</label>
                            <div class="controls">
                                <input class="span3" name="password" required type="password" id="inputEmail0"
                                    placeholder="Password">
                            </div>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn block">Create Your Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span1"> &nbsp;</div>
            <div class="span4">
                @if (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('success_message') }}</strong>
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
                    <h5>ALREADY REGISTERED ?</h5>
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="control-group">
                            <label class="control-label" for="inputEmail1">Email</label>
                            <div class="controls">
                                <input class="span3" type="email" name="email" required id="inputEmail1"
                                    placeholder="Email">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Password</label>
                            <div class="controls">
                                <input type="password" name="password" required class="span3" id="inputPassword1"
                                    placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign in</button> <a
                                    href="{{ url('/forgot-password') }}">Forget
                                    password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
