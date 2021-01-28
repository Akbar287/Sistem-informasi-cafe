@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/customer') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Pelanggan</a></li>
        <li class="breadcrumb-item  active">Lihat Data</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="customer-data" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Data Pelanggan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="address-data" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Alamat Pelanggan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="transaction-data" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="false">Riwayat Transaksi</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active mt-3 mb-3" id="customer" role="tabpanel" aria-labelledby="customer-data">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <img src="{{ asset('/images/customers/'.  $customer->photo) }}" alt="Foto Profil" class="img img-thumbnail img-fluid img-customer">
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>Nama Depan</th>
                                                    <td>{{ $customer->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Belakang</th>
                                                    <td>{{ $customer->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $customer->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td>{{ $customer->username }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Nomor Telepon / HP</th>
                                                    <td>{{ $customer->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Verifikasi Email</th>
                                                    <td>{{ !is_null($customer->email_verified_at) ? 'Terverifikasi' : 'Belum Verifikasi' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status Aktif</th>
                                                    <td>{{ ($customer->isActive == 1) ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Terdaftar Sejak</th>
                                                    <td>{{ date_format($customer->created_at, "d F Y") }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-3 mb-3" id="address" role="tabpanel" aria-labelledby="address-data">
                                <div class="row justify-content-center">
                                    @if(!empty($address))
                                    @foreach($address as $CustomerAddress)
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>Negara</th>
                                                    <td>{{ $CustomerAddress['country'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <td>{{ $CustomerAddress['province'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kota</th>
                                                    <td>{{ $CustomerAddress['city'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <td>{{ $CustomerAddress['District'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <td>{{ $CustomerAddress['subDistrict'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RW</th>
                                                    <td>{{ $CustomerAddress['rw'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RT</th>
                                                    <td>{{ $CustomerAddress['rt'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>No. Rumah</th>
                                                    <td>{{ $CustomerAddress['number_house'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kode Pos</th>
                                                    <td>{{ $CustomerAddress['postal_code'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Default</th>
                                                    <td>{{ ($CustomerAddress['isDefault'] == 1) ? 'Ya' : 'Tidak' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-12 text-center">
                                        <p>Pelanggan Ini Belum Mendaftarkan Alamat</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade mt-3 mb-3" id="transaction" role="tabpanel" aria-labelledby="transaction-data">
                                <table class="table table-hover" id="transaction-history-table">
                                    <thead>
                                        <th>Waktu</th>
                                        <th>Kasir</th>
                                        <th>Produk</th>
                                        <th>Tipe Penjualan</th>
                                        <th>Total</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
            <div class="tile">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Aksi</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ url('/customer/' . $customer->customer_id . '/edit') }}" class="btn btn-primary btn-block" title="Ubah Data Pelanggan"><i class="fa fa-edit"></i> Ubah Data</a>
                        <button class="btn btn-danger btn-block" title="Hapus Data Pelanggan" onclick="event.preventDefault();(confirm('Data Pelanggan, Alamat dan Transaksi yg bersangkutan akan dihapus! Hal ini bisa menyebabkan kesalahan pembacaan laporan keuangan! \nLanjutkan? ') ? document.getElementById('deleteCustomer').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus Data</button>
                        <form action="{{ url('/customer/' . $customer->customer_id) }}" id="deleteCustomer" method="POST">@csrf @method('delete')</form>
                    </div>
                </div>
            </div>
            <div class="tile">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Perilaku</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Jumlah Transaksi</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Total Belanja</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Rata-Rata Belanja</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Sisa Cicilan</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Kedatangan</th>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
