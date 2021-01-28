@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/customer') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Tambah Data</li>
    </ul>
</div>
<div class="container">
    <form action="{{ url('/customer') }}" method="POST" class="form-horizontal" enctype="multipart/form-data"> @csrf
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                <div class="tile mb-4" style="position: sticky;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Foto Profil Pelanggan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Unggah</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image-preview">
                                    <label class="custom-file-label" for="image-preview">Pilih Gambar</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <img src="" alt="Foto Profil" class="img img-thumbnail img-fluid img-customer" style="display: none;">
                        </div>
                        <div class="col-8 text-center m-2">
                            <button class="btn btn-danger btn-block btn-times-image-customer" style="display: none;"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                <div class="tile mb-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Tambah Data Pelanggan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="first_name" class="control-label col-md-3">Nama Depan</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror " name="first_name" id="first_name">
                                    @error('first_name')<div id="first_name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="control-label col-md-3">Nama Belakang</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror " name="last_name" id="last_name">
                                    @error('last_name')<div id="last_name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror " name="email" id="email">
                                    @error('email')<div id="email" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_number" class="control-label col-md-3">Nomor Telepon / HP</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" id="phone_number">
                                    @error('phone_number')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="control-label col-md-3">Username</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror " name="username" id="username">
                                    @error('username')<div id="username" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pin" class="control-label col-md-3">PIN</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('pin') }}" class="form-control @error('pin') is-invalid @enderror " name="pin" id="pin">
                                    @error('pin')<div id="pin" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="control-label col-md-3">Password</label>
                                <div class="col-md-8">
                                    <input type="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror " name="password" id="password">
                                    @error('password')<div id="password" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-10 col-md-8 text-left">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="isActive" name="isActive">
                                        <label class="custom-control-label" for="isActive">Aktifkan User Ini</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tile mb-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Tambah Alamat Pelanggan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="country" class="control-label col-md-3">Negara</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('country') }}" class="form-control @error('country') is-invalid @enderror " name="country" id="country">
                                    @error('country')<div id="country" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="province" class="control-label col-md-3">Provinsi</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('province') }}" class="form-control @error('province') is-invalid @enderror " name="province" id="province">
                                    @error('province')<div id="province" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="control-label col-md-3">Kota</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror " name="city" id="city">
                                    @error('city')<div id="city" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="district" class="control-label col-md-3">Kecamatan</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('district') }}" class="form-control @error('district') is-invalid @enderror " name="district" id="district">
                                    @error('district')<div id="district" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subDistrict" class="control-label col-md-3">Kelurahan</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('subDistrict') }}" class="form-control @error('subDistrict') is-invalid @enderror " name="subDistrict" id="subDistrict">
                                    @error('subDistrict')<div id="subDistrict" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rw" class="control-label col-md-3">RW</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('rw') }}" class="form-control @error('rw') is-invalid @enderror " name="rw" id="rw">
                                    @error('rw')<div id="rw" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rt" class="control-label col-md-3">rt</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('rt') }}" class="form-control @error('rt') is-invalid @enderror " name="rt" id="rt">
                                    @error('rt')<div id="rt" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="number_house" class="control-label col-md-3">Nomor Rumah</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('number_house') }}" class="form-control @error('number_house') is-invalid @enderror " name="number_house" id="number_house">
                                    @error('number_house')<div id="number_house" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="postal_code" class="control-label col-md-3">Kode Pos</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('postal_code') }}" class="form-control @error('postal_code') is-invalid @enderror " name="postal_code" id="postal_code">
                                    @error('postal_code')<div id="postal_code" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-primary" type="submit" title="Tambah Data"><i class="fa fa-pencil"></i> Tambah Pelanggan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
