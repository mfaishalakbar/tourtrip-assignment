@extends('layout.layout')

@section('title', 'TourTrip | Search')

@section('content')
<div class="container">
    <form method="POST" action="/search">
        @csrf
        <input type="hidden" name="start_date" value="{{$start_date}}" />
        <input type="hidden" name="end_date" value="{{$end_date}}" />
        <section style="margin-top: 24px">
            <h1>Akomodasi Tersedia</h1>
            <section style="margin-top: 24px">
                <h2>Tujuan Wisata Tersedia</h2>
                <div class="card-deck">
                    @foreach($trips as $trip)
                    <div style="margin: 12px 0px" class="col-4">
                        <div class="card">
                            <img class="card-img-top" src="{{$trip->image_url}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><input style="margin-right: 12px" name="trips[]" value="{{$trip->id}}" type="checkbox" />{{$trip->name}}</h5>
                                <p class="card-text">{{$trip->description}}</p>
                                <p class="card-text">
                                <h3 class="currency-format">{{$trip->price}}</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            <section style="margin-top: 24px">
                <h2>Hotel Tersedia</h2>
                <div class="card-deck">
                    @foreach($hotels as $hotel)
                    <div style="margin: 12px 0px" class="col-4">
                        <div class="card">
                            <img class="card-img-top" src="{{$hotel->image_url}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><input style="margin-right: 12px" name="hotels[]" value="{{$hotel->id}}" type="checkbox" />{{$hotel->name}}</h5>
                                <p class="card-text">{{$hotel->description}}</p>
                                <p class="card-text">
                                <h3 class="currency-format">{{$hotel->price}}</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </section>

        <section style="margin: 24px 0px">
            <h1>Data Peserta</h1>
            <div class="form-peserta-group">
                <div class="form-peserta">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="register_name">Name</label>
                                <input type="text" required id="register_name" class="form-control" name="member_name[]" />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="register_place_of_birth">Place of Birth</label>
                                <input type="text" required id="register_place_of_birth" class="form-control" name="member_place_of_birth[]" />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="register_date_of_birth">Date of Birth</label>
                                <input type="date" required id="register_date_of_birth" class="form-control" name="member_date_of_birth[]" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="register_address">Address</label>
                                <textarea required id="register_address" class="form-control" name="member_address[]"></textarea>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="register_confirm_password">Gender</label>
                                <select required class="form-control" name="member_gender[]">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>
            </div>

            <button id="add-peserta" class="btn btn-secondary btn-md btn-block">Tambah Peserta</button>
        </section>

        <button class="btn btn-primary btn-md btn-block">Checkout</button>
    </form>
</div>
@endsection

@section('script')
<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    const toBeFormatted = $('.currency-format')
    for (let i = 0; i < toBeFormatted.length; i++) {
        const current = toBeFormatted[i];
        current.innerText = `Rp. ${numberWithCommas(current.innerText)}`
    }

    $("#add-peserta").click((e) => {
        e.preventDefault();
        let clone = $('.form-peserta-group').clone('.form-peserta');
        $('.form-peserta').append(clone);
    })
</script>
@endsection