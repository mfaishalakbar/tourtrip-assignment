@extends('layout.layout')

@section('title', 'TourTrip')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">TourTrip</h1>
        <p class="lead">Rencanakan perjalanan tinggal klik aja</p>
        <hr class="my-4">
        @if(Auth::check())
        <div class="col-12" style="margin: 24px 0px">
            <div class="row">
                <div class="col-5">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="login_password">Kota Destinasi</label>
                        <select class="form-control item-id" id="city" name="city">
                            <option value="0" selected disabled>Select City</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="date">Range Tanggal</label>
                        <input type="text" id="daterahge" name="dates" class="form-control" />
                    </div>
                </div>
                <div class="col-2">
                    <a style="margin-top: 32px" class="btn btn-primary btn-md" href="#" id="cari" role="button">Cari</a>
                </div>
            </div>
        </div>
        <div class="col lg-12" style="align-self:center">
            <p>It seems you're logged in now. You can logout and re-login again.</p>
        </div>
        @else
        <p>Untuk memulai perjalanan, mohon login atau registrasi terlebih dahulu.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
        </p>
        @endif

    </div>
</div>
@endsection

@section('script')
<script>
    let startDate = '';
    let endDate = '';
    $('input[name="dates"]').daterangepicker({
        minDate: new Date(),
        maxSpan: {
            "days": 7
        }
    }, function(start, end, label) {
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');
    });

    $('#cari').click((e) => {
        e.preventDefault();
        if(startDate == '' || endDate == '') {
            alert('Pilih Range Tanggal!');
            return;
        }

        if($('#city').val() < 1) {
            alert('Pilih Kota Tujuan!');
        }

        window.location = `/search?start_date=${startDate}&end_date=${endDate}&city=${$('#city').val()}`
    })
</script>
@endsection