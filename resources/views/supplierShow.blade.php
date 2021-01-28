@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/supplier') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/supplier') }}">Supplier</a></li>
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
                                    <th>ID Supplier</th>
                                    <td>{{ $supplier->supplier_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <td>{{ $supplier->company }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pegawai / Perwakilan</th>
                                    <td>{{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon / HP</th>
                                    <td>{{ $supplier->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $supplier->email }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $supplier->address }}</td>
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
                                    <td>{{ date_format($supplier->created_at, "d F Y") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-10 text-center">
                        <div class="btn-group">
                            <a href="{{ url('/supplier' ) }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ url('/supplier/'. $supplier->supplier_id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i> Ubah Supplier</a>
                            <button class="btn btn-danger" title="Hapus" onclick="event.preventDefault();(confirm('Data supplier yang sudah dihapus tidak dapat dikembalikan! \nLanjutkan? ') ? document.getElementById('deleteSupplier').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus Supplier</button>
                            <form action="{{ url('/supplier/' . $supplier->supplier_id) }}" id="deleteSupplier" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
