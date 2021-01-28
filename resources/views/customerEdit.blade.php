@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/customer/'.$customer->customer_id) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Pelanggan</a></li>
        <li class="breadcrumb-item  active">Ubah Data</li>
    </ul>
</div>
<div class="container">
    <form action="{{ url('/customer/' . $customer->customer_id) }}" enctype="multipart/form-data" method="POST"> @csrf @method('put')
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                @if(session('msg')) {!! session('msg') !!} @endif
                <div class="alert alert-info" role="alert"><strong>Untuk Keamanan</strong>! Foto, Alamat dan Riwayat Transaksi Hanya dapat diubah oleh Pelanggan.</div>
                <div class="tile">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <ul class="nav nav-pills" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="customer-data" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Data Pelanggan</a>
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
                                                        <th><label for="first_name">Nama Depan</label></th>
                                                        <td><input type="text" value="{{ $customer->first_name }}" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name">
                                                        @error('first_name')<div id="first_name" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="last_name">Nama Belakang</label></th>
                                                        <td><input type="text" id="last_name" value="{{ $customer->last_name }}" name="last_name" class="form-control @error('last_name') is-invalid @enderror">
                                                        @error('last_name')<div id="last_name" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="email">Email</label></th>
                                                        <td><input type="text" id="email" value="{{ $customer->email }}" name="email" class="form-control @error('email') is-invalid @enderror">@error('email')<div id="email" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="username">Username</label></th>
                                                        <td><input id="username" type="text" value="{{ $customer->username }}" name="username" class="form-control @error('username') is-invalid @enderror">
                                                        @error('username')<div id="username" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="phone_number">Nomor Telepon / HP</label></th>
                                                        <td><input type="text" id="phone_number" value="{{ $customer->phone_number }}" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror">@error('phone_number')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="email_verified_at">Verifikasi Email</label></th>
                                                        <td>
                                                            <select name="email_verified_at" id="email_verified_at" class="custom-select @error('email_verified_at') is-invalid @enderror">
                                                                <option value="0" {{ is_null($customer->email_verified_at) ? 'selected' : ''}}>Belum Verifikasi</option>
                                                                <option value="1" {{is_null($customer->email_verified_at) ? '' : 'selected'}}>Terverifikasi</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="isActive">Status Aktif</label></th>
                                                        <td>
                                                            <select id="isActive" name="isActive" class="custom-select @error('isActive') is-invalid @enderror">
                                                                <option value="0" {{ ($customer->isActive == 1) ? '' : 'selected'}}>Tidak Aktif</option>
                                                                <option value="1" {{ ($customer->isActive == 1) ? 'selected' : ''}}>Aktif</option>
                                                            </select>
                                                        </td>
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
                            <a href="{{ url('/customer/' . $customer->customer_id ) }}" class="btn btn-info btn-block" title="Batalkan"><i class="fa fa-times"></i> Batalkan Perubahan</a>
                            <button class="btn btn-primary btn-block" type="submit" title="Simpan Data Pelanggan"><i class="fa fa-edit"></i> Simpan Perubahan</button>
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
    </form>
</div>
@endsection
