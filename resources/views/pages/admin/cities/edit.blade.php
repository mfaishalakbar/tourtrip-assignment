@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Create Item</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{ old('name', $data->name) }}" class="form-control @error('name') is-invalid @enderror" name="name">
            
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description', $data->description) is-invalid @enderror" name="description">{{ old('description', $data->description) }}</textarea>
            
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" value="{{ old('country', $data->country) }}" class="form-control @error('country') is-invalid @enderror" name="country">
            
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="text" value="{{ old('image_url', $data->image_url) }}" class="form-control @error('image_url') is-invalid @enderror" name="image_url">
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