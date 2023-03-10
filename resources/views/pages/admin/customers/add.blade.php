@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Create Customer</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" name="name">
            
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="name">Place of Birth</label>
                <input type="text" value="{{ old('place_of_birth') }}" class="form-control @error('place_of_birth') is-invalid @enderror" name="place_of_birth">
            
            @error('place_of_birth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="name">Date of Birth</label>
                <input type="date" value="{{ old('date_of_birth') }}" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth">
            
            @error('date_of_birth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="name">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>
            
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                    <option value="L" @if (old('gender') == "L") {{ 'selected' }} @endif>Laki-Laki</option>
                    <option value="P" @if (old('gender') == "P") {{ 'selected' }} @endif>Perempuan</option>
                </select>

            @error('gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" name="email">
            
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
            
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
            
            @error('confirm_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')

@stop