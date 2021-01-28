@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-user"></i> Profil</h1>
        <p>Registered {{ date_format(Auth::user()->created_at, "d F Y") }}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item active">Profil</li>
    </ul>
</div>
<form action="{{ url('/profile') }}" method="POST" id="form-image" enctype="multipart/form-data">@csrf
    @method('put')
    @if(session('msg')) {!! session('msg') !!} @endif
    <div class="row">
        <div class="col-12 col-sm-12 col-md-5 col-lg-4">
            <div class="tile">
                <div class="tile-body">
                    <img src="{{ asset('images/profile/' . Auth::user()->photo) }}" class="img img-thumbnail img-fluid img-profile mb-3" width="100%" alt="Profile Image">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-primary" id="show-input-image" title="Ganti Foto"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-info" id="undo-preview-image" title="Batalkan" style="display: none;"><i class="fa fa-undo"></i></button>
                            <button type="button" class="btn btn-danger img-delete" title="Hapus Foto"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <input type="file" name="image" class="form-control m-2" id="image-preview" style="display: none;">
                            <input type="hidden" name="imageClear" id="imageClear" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-7 col-lg-8">
            <div class="tile">
                <div class="tile-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Data Pribadi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="address-tab" data-toggle="pill" href="#address" role="tab" aria-controls="address" aria-selected="false">Alamat</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="log-tab" data-toggle="pill" href="#log" role="tab" aria-controls="log" aria-selected="false">Riwayat Log</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row justify-content-center mb-3">
                                <div class="col-6">
                                    <label for="first_name">Nama Depan</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="Nama Depan" value="{{ Auth::user()->first_name }}" name="first_name" id="first_name">
                                    @error('first_name')<div id="first_name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6">
                                    <label for="last_name">Nama Belakang</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Nama Belakang" value="{{ Auth::user()->last_name }}" name="last_name" id="last_name">
                                    @error('last_name')<div id="last_name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{ Auth::user()->email }}" name="email" id="email">
                                    @error('email')<div id="email" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-8 mb-3">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ Auth::user()->username }}" name="username" id="username">
                                    @error('username')<div id="username" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-3">
                                    <label for="phone_number">Nomor Telepon / HP</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Nomor Telepon / HP" value="{{ Auth::user()->phone_number }}" name="phone_number" id="phone_number">
                                    @error('phone_number')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="pin">Pin</label>
                                    <input type="text" class="form-control @error('pin') is-invalid @enderror" placeholder="Pin" value="{{ Auth::user()->pin }}" name="pin" id="pin">
                                    <small class="form-text text-muted">Pin akan digunakan untuk penggunaan Mesin Kasir.</small>
                                    @error('pin')<div id="pin" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Isi Jika ingin diGanti" name="password" id="password">
                                    @error('password')<div id="password" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="country" class="control-label col-md-3">Negara</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ (!empty($address)) ? $address['country'] : old('country') }}" class="form-control @error('country') is-invalid @enderror " name="country" id="country">
                                            @error('country')<div id="country" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="province" class="control-label col-md-3">Provinsi</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['province'] :  old('province') }}" class="form-control @error('province') is-invalid @enderror " name="province" id="province">
                                            @error('province')<div id="province" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city" class="control-label col-md-3">Kota</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['city'] :  old('city') }}" class="form-control @error('city') is-invalid @enderror " name="city" id="city">
                                            @error('city')<div id="city" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="district" class="control-label col-md-3">Kecamatan</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['District'] :  old('district') }}" class="form-control @error('district') is-invalid @enderror " name="district" id="district">
                                            @error('district')<div id="district" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subDistrict" class="control-label col-md-3">Kelurahan</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['subDistrict'] :  old('subDistrict') }}" class="form-control @error('subDistrict') is-invalid @enderror " name="subDistrict" id="subDistrict">
                                            @error('subDistrict')<div id="subDistrict" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rw" class="control-label col-md-3">RW</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['rw'] :  old('rw') }}" class="form-control @error('rw') is-invalid @enderror " name="rw" id="rw">
                                            @error('rw')<div id="rw" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rt" class="control-label col-md-3">rt</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['rt'] :  old('rt') }}" class="form-control @error('rt') is-invalid @enderror " name="rt" id="rt">
                                            @error('rt')<div id="rt" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number_house" class="control-label col-md-3">Nomor Rumah</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['number_house'] :  old('number_house') }}" class="form-control @error('number_house') is-invalid @enderror " name="number_house" id="number_house">
                                            @error('number_house')<div id="number_house" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="postal_code" class="control-label col-md-3">Kode Pos</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{  (!empty($address)) ? $address['postal_code'] :  old('postal_code') }}" class="form-control @error('postal_code') is-invalid @enderror " name="postal_code" id="postal_code">
                                            @error('postal_code')<div id="postal_code" class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade table-responsive" id="log" role="tabpanel" aria-labelledby="log-tab">
                            <table class="table table-hover" id="log-profile-table">
                                <thead>
                                    <th>Waktu</th>
                                    <th>Aktivitas</th>
                                    <th>Nama Class</th>
                                    <th>Nama Function</th>
                                    <th>Alamat IP</th>
                                </thead>
                                <tbody>
                                    @foreach($log as $history)
                                    <tr>
                                        <td>{{ date_format($history->created_at, "d/m/Y H:i") }}</td>
                                        <td>{{ $history->title }}</td>
                                        <td>{{ $history->className }}</td>
                                        <td>{{ $history->functionName }}</td>
                                        <td>{{ $history->ip_address }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-pencil"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
