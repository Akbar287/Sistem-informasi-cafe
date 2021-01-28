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
                                <a class="nav-link" id="address-data" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Alamat Karyawan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="outlet-data" data-toggle="tab" href="#outlet" role="tab" aria-controls="outlet" aria-selected="false">Data Outlet</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="log-data" data-toggle="tab" href="#log" role="tab" aria-controls="log" aria-selected="false">Riwayat Log</a>
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
                                                    <th>Nama Depan</th>
                                                    <td>{{ $employee->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Belakang</th>
                                                    <td>{{ $employee->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $employee->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td>{{ $employee->username }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Nomor Telepon / HP</th>
                                                    <td>{{ $employee->phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Verifikasi Email</th>
                                                    <td>{{ !is_null($employee->email_verified_at) ? 'Terverifikasi' : 'Belum Verifikasi' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status Aktif</th>
                                                    <td>{{ ($employee->isActive == 1) ? 'Aktif' : 'Tidak Aktif' }}</td>
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
                            <div class="tab-pane fade mt-3 mb-3" id="address" role="tabpanel" aria-labelledby="address-data">
                                <div class="row justify-content-center">
                                    @if(!empty($address))
                                    @foreach($address as $employeeAddress)
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>Negara</th>
                                                    <td>{{ $employeeAddress['country'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <td>{{ $employeeAddress['province'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kota</th>
                                                    <td>{{ $employeeAddress['city'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <td>{{ $employeeAddress['District'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <td>{{ $employeeAddress['subDistrict'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RW</th>
                                                    <td>{{ $employeeAddress['rw'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>RT</th>
                                                    <td>{{ $employeeAddress['rt'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>No. Rumah</th>
                                                    <td>{{ $employeeAddress['number_house'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kode Pos</th>
                                                    <td>{{ $employeeAddress['postal_code'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Default</th>
                                                    <td>{{ ($employeeAddress['isDefault'] == 1) ? 'Ya' : 'Tidak' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-12 text-center">
                                        <p>{{ (Auth::user()->user_id == $employee->user_id) ? 'Anda' : 'Karyawan Ini' }} Belum Mendaftarkan Alamat</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade mt-3 mb-3" id="outlet" role="tabpanel" aria-labelledby="outlet-data">
                                @if(count((array)$outletEmployee))
                                <p>Karyawan ini mengatur outlet: </p>
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($outletEmployee as $oe)
                                        <tr>
                                            <td>
                                                {{ $oe['name'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p>{{ (Auth::user()->user_id == $employee->user_id) ? 'Anda' : 'Karyawan Ini' }} Belum Terdaftar di outlet manapun.</p>
                                @endif
                            </div>
                            <div class="tab-pane fade mt-3 mb-3" id="log" role="tabpanel" aria-labelledby="log-data">
                                <table class="table table-hover" id="log-employee-table">
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
                        <button onclick="window.location.href='{{ url('/employee/' . $employee->user_id . '/edit') }}'" class="btn btn-primary btn-block" title="Ubah Data Pelanggan" {{ ($employee->user_id == Auth::user()->user_id) ? 'disabled' : '' }}><i class="fa fa-edit"></i> Ubah Data</button>
                        <button class="btn btn-danger btn-block" title="Hapus Data Pelanggan" onclick="event.preventDefault();(confirm('Data Pelanggan, Alamat dan Transaksi yg bersangkutan akan dihapus! Hal ini bisa menyebabkan kesalahan pembacaan laporan keuangan! \nLanjutkan? ') ? document.getElementById('deleteEmployee').submit() : event.preventDefault() );" {{ ($employee->user_id == Auth::user()->user_id) ? 'disabled' : '' }}><i class="fa fa-trash"></i> Hapus Data</button>
                        <form action="{{ url('/employee/' . $employee->user_id) }}" id="deleteEmployee" method="POST">@csrf @method('delete')</form>
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
                        <h3>{{ $employee->roleName }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
