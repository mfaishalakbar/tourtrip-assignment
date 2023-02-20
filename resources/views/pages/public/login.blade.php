@extends('layout.layout')

@section('title', 'TourTrip | Login')

@section('content')


<div class="container">
    <div class="row" style="margin: 12px 0px">
        <div class="col-12" style="margin: 24px 0px">
            <div class="text-center">
                <h2>Login to System</h2>
            </div>
        </div>
        <div class="col-12" style="align-self:center; text-align:center">
            <p>Please enter your credentials to start your journey.</p>
        </div>
        <div class="col-12 mt-4" style="max-width: 30vw; margin: 0 auto">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="">
                @csrf
                <div class="form-outline mb-4">
                    <label class="form-label" for="login_username">Email</label>
                    <input type="text" id="login_username" name="email" class="form-control" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="login_password">Password</label>
                    <input type="password" id="login_password" name="password" class="form-control" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="login_captcha">Captcha</label>
                    <p style="font-weight: bold">{{$captcha}}</p>
                    <input type="number" id="login_captcha" name="captcha" class="form-control" />
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <a href="/reset-password">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
            </form>
        </div>
    </div>
</div>
@endsection