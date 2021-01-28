@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-percent"></i> Promo</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item active">Promo</li>
    </ul>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10">
        <div class="tile">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="special-promo-tab" data-toggle="pill" href="#special-promo" role="tab" aria-controls="special-promo" aria-selected="true">Promo Spesial</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="voucher-tab" data-toggle="pill" href="#voucher" role="tab" aria-controls="voucher" aria-selected="false">Voucher</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="special-promo" role="tabpanel" aria-labelledby="special-promo-tab">
                            <div class="row">
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ url('/promo/special') }}" class="btn btn-primary" title="Tambah Promo Spesial"><i class="fa fa-pencil"></i> Tambah Promo Spesial</a>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="table-special-promo">
                                            <thead>
                                                <th>Nama</th>
                                                <th>Diskon</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </thead>
                                            <tbody>
                                                @foreach($specialPromo as $promo)
                                                <tr>
                                                    <td>{{ $promo->name }}</td>
                                                    <td>{{ ($promo->isType == 1) ? '' : 'Rp.' }} {{ ($promo->isType == 0) ? number_format($promo->discount, 2, '.', ',') : $promo->discount }} {{ ($promo->isType == 1) ? '%' : '' }}</td>
                                                    <td>{{ ($promo->isActive) ? 'Aktif' : 'Tidak' }}</td>
                                                    <td><a href="{{ url('/promo/special/' .$promo->special_promo_id) }}" class="btn btn-primary btn-sm" title="Lihat Detail"><i class="fa fa-info"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="voucher" role="tabpanel" aria-labelledby="voucher-tab">
                            <div class="row">
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ url('/promo/voucher') }}" class="btn btn-primary" title="Tambah Voucher"><i class="fa fa-pencil"></i> Tambah Voucher</a>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="table-voucher-promo">
                                            <thead>
                                                <th>Nama</th>
                                                <th>Kode</th>
                                                <th>Diskon</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </thead>
                                            <tbody>
                                                @foreach($vouchers as $voucher)
                                                <tr>
                                                    <td>{{ $voucher->name }}</td>
                                                    <td>{{ $voucher->code }}</td>
                                                    <td>{{ ($voucher->isType == 1) ? '' : 'Rp.' }} {{ ($voucher->isType == 0) ? number_format($voucher->discount, 2, '.', ',') : $voucher->discount }} {{ ($voucher->isType == 1) ? '%' : '' }}</td>
                                                    <td>{{ ($voucher->isActive) ? 'Aktif' : 'Tidak' }}</td>
                                                    <td><a href="{{ url('/promo/voucher/' .$voucher->voucher_id) }}" class="btn btn-sm btn-primary" title="Lihat Detail"><i class="fa fa-info"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
