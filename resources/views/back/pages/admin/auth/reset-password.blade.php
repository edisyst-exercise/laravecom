@extends('back.layout.auth-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Reset Password')

@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
        </div>
        <h6 class="mb-20">Enter your new password, confirm and submit</h6>

        <form action="{{ route('admin.reset-password-handler', ['token' => request()->token]) }}" method="post">
            @csrf
            @if( \Illuminate\Support\Facades\Session::get('fail') )
                <div class="alert alert-danger">
                    {{ \Illuminate\Support\Facades\Session::get('fail') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
            @if( \Illuminate\Support\Facades\Session::get('success') )
                <div class="alert alert-success">
                    {{ \Illuminate\Support\Facades\Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="input-group custom">
                <input type="text" class="form-control form-control-lg" name="new_password" value="{{ old('new_password') }}" placeholder="New Password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password')
                <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">{{ $message }}</div>
            @enderror

            <div class="input-group custom">
                <input type="text" class="form-control form-control-lg" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}" placeholder="Confirm New Password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password_confirmation')
                <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">{{ $message }}</div>
            @enderror

            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
