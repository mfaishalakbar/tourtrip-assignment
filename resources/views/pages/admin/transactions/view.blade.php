@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Transaction Details</h1>
@stop

@section('content')
<div class="container">
    <section style="margin-top: 24px">
        <h1>Transaction Detail</h1>
        <section style="margin-top: 24px">

            <div class="container-fluid">
                <div id="ui-view" data-select2-id="ui-view">
                    <div>
                        <div class="card">
                            <div class="card-header">Transaction ID
                                <strong>#{{$transaction->id}}</strong>
                                <a class="btn btn-sm btn-secondary float-right mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                                    <i class="fa fa-print"></i> Print</a>

                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        <div>
                                            <strong>{{$transaction->customer()->first()->user()->first()->name}}</strong>
                                        </div>
                                        <div>{{$transaction->customer()->first()->address}}</div>
                                        <div>Email: {{$transaction->customer()->first()->user()->first()->email}}</div>
                                    </div>
                                </div>

                                <div class="table-responsive-sm">
                                    <h3>Itinerary Detail</h3>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th class="right">Price</th>
                                                <th class="right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->details()->get() as $detail)
                                            @if($detail->trip()->first())
                                            <tr>
                                                <td class="left">{{$detail->trip()->first()->name}}</td>
                                                <td class="left">Admission for {{$detail->trip()->first()->name}}</td>
                                                <td class="right currency-format">{{$detail->price}}</td>
                                                <td class="right currency-format">{{$detail->total_price}}</td>
                                            </tr>
                                            @endif

                                            @if($detail->hotel()->first())
                                            <tr>
                                                <td class="left">{{$detail->hotel()->first()->name}}</td>
                                                <td class="left">Booking {{$detail->hotel()->first()->name}} for {{$days}} days</td>
                                                <td class="right currency-format">{{$detail->price}}</td>
                                                <td class="right currency-format">{{$detail->total_price}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive-sm mt-4">
                                    <h3>Member List</h3>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->members()->get() as $detail)
                                            <tr>
                                                <td class="left">{{$detail->name}}</td>
                                                <td class="left">{{$detail->address}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-5 ml-auto">
                                        <table class="table table-clear">
                                            <tbody>
                                                <tr>
                                                    <td class="left">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td class="right">
                                                        <strong class="currency-format">{{$transaction->total}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const toBeFormatted = $('.currency-format')
    for (let i = 0; i < toBeFormatted.length; i++) {
        const current = toBeFormatted[i];
        current.innerText = `Rp. ${numberWithCommas(current.innerText)}`
    }
</script>
@stop