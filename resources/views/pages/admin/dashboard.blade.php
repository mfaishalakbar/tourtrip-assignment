@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Welcome, {{auth()->user()->name}}</h1>
@stop

@section('content')
    <p>Welcome to TourTrip, Please use menu at the left side to begin.</p>
@stop

@section('css')
   
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop