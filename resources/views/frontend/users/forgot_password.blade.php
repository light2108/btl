@extends('layouts.frontend_layout.frontend_layout')
@section('content')
    <!-- Sidebar end=============================================== -->
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Forget password?</li>
        </ul>
        <h3> FORGET YOUR PASSWORD?</h3>
        <hr class="soft" />
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
        <div class="row">
            <div class="span9" style="min-height:900px">
                <div class="well">
                    <h5>Reset your password</h5><br />
                    Please enter the email address for your account. A verification code will be sent to
                    you. Once you have received the verification code, you will be able to choose a new
                    password for your account.<br /><br /><br />
                    <form action="{{url('/forgot-password')}}" method="POST">
                        @csrf
                        <div class="control-group">
                            <label class="control-label" for="inputEmail1">E-mail address</label>
                            <div class="controls">
                                <input class="span3" type="text" id="inputEmail1" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
