@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Edit Trip</h1>
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
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
            
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="days">Days</label>
                <input type="number" value="{{ old('days') }}" class="form-control @error('days') is-invalid @enderror" name="days">
            
            @error('days')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" name="price">
            
            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <select class="form-control item-id" name="city">
                    <option value="0" selected disabled>Select City</option>
                    @foreach($cities as $city)
                    <option @if(old('city') == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
            @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="text" value="{{ old('image_url') }}" class="form-control @error('image_url') is-invalid @enderror" name="image_url">
                <small>Please upload picture manually and paste uploaded URL here</small>
                
            @error('image_url')
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