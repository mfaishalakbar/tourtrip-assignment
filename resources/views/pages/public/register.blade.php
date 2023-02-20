@extends('layout.layout')

@section('title', 'TourTrip | Register')

@section('content')


<div class="container">
    <div class="row" style="margin: 12px 0px">
        <div class="col-12" style="margin: 24px 0px">
            <div class="text-center">
                <h2>Register</h2>
            </div>
        </div>
        <div class="col-12 mt-4" style="max-width: 30vw; margin: 0 auto">
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
                    <label class="form-label" for="register_name">Name</label>
                    <input type="text" value="{{old('name')}}" id="register_name" class="form-control" name="name" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_username">Email</label>
                    <input type="text" value="{{old('email')}}" id="register_username" class="form-control" name="email" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_place_of_birth">Place of Birth</label>
                    <input type="text" value="{{old('place_of_birth')}}" id="register_place_of_birth" class="form-control" name="place_of_birth" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_date_of_birth">Date of Birth</label>
                    <input type="date" value="{{old('date_of_birth')}}" id="register_date_of_birth" class="form-control" name="date_of_birth" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_address">Address</label>
                    <textarea id="register_address" class="form-control" name="address">{{old('address')}}</textarea>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_confirm_password">Gender</label>
                    <select class="form-control" name="gender">
                        <option value="L" @if (old('gender') == "L") {{ 'selected' }} @endif>Laki-Laki</option>
                        <option value="P" @if (old('gender') == "P") {{ 'selected' }} @endif>Perempuan</option>
                    </select>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_password">Password</label>
                    <input type="password" id="register_password" name="password" class="form-control" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="register_confirm_password">Confirm Password</label>
                    <input type="password" id="register_confirm_password" name="confirm_password" class="form-control" />
                </div>

                <button type="submit" action="submit" class="btn btn-primary btn-block mb-4">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection