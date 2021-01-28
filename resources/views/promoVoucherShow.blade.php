@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/promo') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/promo') }}">Promo</a></li>
        <li class="breadcrumb-item active">Lihat Voucher</li>
    </ul>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10">
        @if(session('msg')) {!! session('msg') !!} @endif
        <div class="tile">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h2 class="mb-3 line-head">Detail Voucher</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr class="tbody">
                                <tr>
                                    <th>Nama Voucher</th>
                                    <td>{{ $voucher['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Voucher</th>
                                    <td>{{ $voucher['code'] }}</td>
                                </tr>
                                <tr>
                                    <th>Diskon</th>
                                    <td>{{ (($voucher['isType'] == 1) ? '' : 'Rp. '). $voucher['discount'] .(($voucher['isType'] == 1) ? ' %' : '')}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ($voucher['isActive'] == 1) ? 'Aktif' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Mulai</th>
                                    <td>{{ $voucher['start_date'] }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Selesai</th>
                                    <td>{{ $voucher['end_date'] }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ ($voucher['description'] == ' ') ? '-' : $voucher['description'] }}</td>
                                </tr>
                                <tr>
                                    <th>Berlaku di Outlet</th>
                                    <td>
                                        <ul>
                                            @foreach($outlets as $outlet)
                                            <li>{{ $outlet['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <div class="btn-group">
                        <a href="{{ url('/promo') }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <a href="{{ url('/promo/voucher/' . $voucher['voucher_id'] . '/edit') }}" class="btn btn-primary" title="Ubah Promo"><i class="fa fa-edit"></i> Ubah</a>
                        <button class="btn btn-danger" title="Hapus Promo" onclick="event.preventDefault();(confirm('Voucher yang sudah dihapus tidak dapat dikembalikan! \nLanjutkan? ') ? document.getElementById('deleteVoucher').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus</button>
                        <form action="{{ url('/promo/voucher/' . $voucher['voucher_id']) }}" id="deleteVoucher" method="POST">@csrf @method('delete')</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
