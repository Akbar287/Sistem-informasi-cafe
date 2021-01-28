@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/outlet') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/outlet') }}">Outlet</a></li>
        <li class="breadcrumb-item active">Lihat Data</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Detail</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID Outlet</th>
                                    <td>{{ $outlet->outlet_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $outlet->name }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon / HP</th>
                                    <td>{{ $outlet->telephone }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>{{ $outlet->city }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $outlet->address }}</td>
                                </tr>
                                <tr>
                                    <th>Modul Meja</th>
                                    <td>{{ ($outlet->isTable) ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <th>Aktif</th>
                                    <td>{{ ($outlet->isActive) ? 'Ya' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <th>Pajak: </th>
                                    <td>
                                        @if(!empty($tax))
                                        <ul>
                                            @foreach($tax as $thisTax)
                                            <li>
                                                {{ ($thisTax['name'] )}} ({{ ($thisTax['typeName'] )}})
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p>Tidak ada pajak</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date_format($outlet->created_at, "d F Y") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-10 text-center">
                        <div class="btn-group">
                            <a href="{{ url('/outlet') }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ url('/outlet/'. $outlet->outlet_id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i> Ubah Outlet</a>
                            <button class="btn btn-danger" title="Hapus" onclick="event.preventDefault();(confirm('Data Outlet yang sudah dihapus tidak dapat dikembalikan! \nLanjutkan? ') ? document.getElementById('deleteOutlet').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus Outlet</button>
                            <form action="{{ url('/outlet/' . $outlet->outlet_id) }}" id="deleteOutlet" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
