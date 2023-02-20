@extends('layout.layout')

@section('title', 'TourTrip | Transaction')

@section('content')
<div class="container">
    <section style="margin-top: 24px">
        <h1>List Transaction</h1>
        <section style="margin-top: 24px">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </section>
    </section>
</div>
@endsection

@section('script')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection