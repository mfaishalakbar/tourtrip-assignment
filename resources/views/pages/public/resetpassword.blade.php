@extends('layout.layout')

@section('title', 'TourTrip | Reset Password')

@section('content')


<div class="container">
    <div class="row" style="margin: 12px 0px">
        <div class="col-12" style="margin: 24px 0px">
            <div class="text-center">
                <h2>Reset Password</h2>
            </div>
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
                    <label class="form-label" for="login_username">Username</label>
                    <input type="text" id="login_username" name="username" class="form-control" />
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4">Reset</button>
            </form>
        </div>
    </div>
</div>
@endsection