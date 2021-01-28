@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/employees') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/employees') }}">Karyawan</a></li>
        <li class="breadcrumb-item active">Lihat Data</li>
    </ul>
</div>
<div class="container">
    <form action="{{ url('/employee/'. $employee->user_id) }}" enctype="multipart/form-data" method="POST">@csrf @method('put')
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                @if($employee->user_id == Auth::user()->user_id)
                <div class="alert alert-info" role="alert"><strong>Pemberitahuan!</strong> Anda tidak dapat menghapus akun anda sendiri.</div>
                @endif
                @if(session('msg')) {!! session('msg') !!} @endif
                <div class="tile">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <ul class="nav nav-pills" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="employee-data" data-toggle="tab" href="#employee" role="tab" aria-controls="employee" aria-selected="true">Data Karyawan</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="outlet-data" data-toggle="tab" href="#outlet" role="tab" aria-controls="outlet" aria-selected="false">Data Outlet</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active mt-3 mb-3" id="employee" role="tabpanel" aria-labelledby="employee-data">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                            <img src="{{ asset('/images/profile/'.  $employee->photo) }}" alt="Foto Profil" class="img img-thumbnail img-fluid img-customer">
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <th><label for="first_name">Nama Depan</label></th>
                                                        <td><input type="text" value="{{ $employee->first_name }}" name="first_name" class="form-control @error('first_name') is-invalid @enderror" id="first_name">@error('first_name') <div id="last_name" class="invalid-feedback">{{ $message }}</div> @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="last_name">Nama Belakang</label></th>
                                                        <td><input type="text" value="{{ $employee->last_name }}" name="last_name" class="form-control @error('last_name') is-invalid @enderror" id="last_name">@error('last_name') <div id="last_name" class="invalid-feedback">{{ $message }}</div> @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="email">Email</label></th>
                                                        <td><input type="text" value="{{ $employee->email }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email">@error('email') <div id="email" class="invalid-feedback">{{ $message }}</div> @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="username">Username</label></th>
                                                        <td><input type="text" value="{{ $employee->username }}" name="username" class="form-control @error('username') is-invalid @enderror" id="username">@error('username') <div id="username" class="invalid-feedback">{{ $message }}</div> @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="phone_number">Nomor Telepon / HP</label></th>
                                                        <td><input type="text" value="{{ $employee->phone_number }}" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number">@error('phone_number') <div id="last_name" class="invalid-feedback">{{ $message }}</div> @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="">Verifikasi Email</label></th>
                                                        <td>
                                                            <select name="email_verified_at" id="email_verified_at" class="custom-select @error('email_verified_at') is-invalid @enderror">
                                                                <option value="0" {{ is_null($employee->email_verified_at) ? 'selected' : ''}}>Belum Verifikasi</option>
                                                                <option value="1" {{is_null($employee->email_verified_at) ? '' : 'selected'}}>Terverifikasi</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><label for="">Status Aktif</label></th>
                                                        <td>
                                                            <select id="isActive" name="isActive" class="custom-select @error('isActive') is-invalid @enderror">
                                                                <option value="0" {{ ($employee->isActive == 1) ? '' : 'selected'}}>Tidak Aktif</option>
                                                                <option value="1" {{ ($employee->isActive == 1) ? 'selected' : ''}}>Aktif</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Terdaftar Sejak</th>
                                                        <td>{{ date_format($employee->created_at, "d F Y") }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade mt-3 mb-3" id="outlet" role="tabpanel" aria-labelledby="outlet-data">
                                    <p>Karyawan ini mengatur outlet: </p>
                                    <div class="form-group row">
                                        <label for="outlets" class="control-label col-md-3">Outlet</label>
                                        <div class="col-md-8">
                                            @if(!empty($outlets))
                                            <select name="outlets[]" multiple="multiple" id="outlets" style="width: 100%" class="select-employee-outlet form-control custom-select @error('outlets') is-invalid @enderror">
                                                @foreach($outlets as $outlet)
                                                    <option value="{{ $outlet->outlet_id }}" {{ (in_array($outlet->outlet_id, $outletEmployee)) ? 'selected' : '' }}>{{ $outlet->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('outlets')<div id="outlets" class="invalid-feedback">{{ $message }}</div>@enderror
                                            @else
                                            <select name="outlets[]" disabled multiple="multiple" id="outlets" style="width: 100%" class="select-tax-outlet form-control custom-select @error('outlets') is-invalid @enderror"></select>
                                            @endif
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
                            <a href="{{ url('/employee/' . $employee->user_id ) }}" class="btn btn-info btn-block" title="Batalkan"><i class="fa fa-times"></i> Batalkan Perubahan</a>
                            <button class="btn btn-primary btn-block" type="submit" title="Simpan Data Karyawan"><i class="fa fa-edit"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
                <div class="tile">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Role</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Saat ini Role: <strong>{{ $employee->roleName }}</strong></p>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="role" class="control-label col-md-3">Role</label>
                                <div class="col-md-8">
                                    @if(!empty($role))
                                    <select name="role" id="role" class="custom-select @error('role') is-invalid @enderror">
                                        @foreach($role as $thisRole)
                                        <option value="{{ $thisRole->role_type_id }}" {{ ($thisRole->role_type_id == $employee->roleId) ? 'selected' : '' }}>{{ $thisRole->name }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
