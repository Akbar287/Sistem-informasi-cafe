@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/tax') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/tax') }}">Pajak & Services</a></li>
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
                                    <th>ID Tax</th>
                                    <td>{{ $taxes->tax_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $taxes->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <td>{{ $taxes->type }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ intVal($taxes->total) }} %</td>
                                </tr>
                                <tr>
                                    <th>Outlet</th>
                                    <td>
                                        @if(!empty($outlet))
                                        <ul>
                                            @foreach($outlet as $thisOutlet)
                                            <li>{{ $thisOutlet['name'] }}</li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p>Tidak diterapkan Di Outlet</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ date_format($taxes->created_at, "d F Y") }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-10 text-center">
                        <div class="btn-group">
                            <a href="{{ url('/tax') }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ url('/tax/'. $taxes->tax_id . '/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i> Ubah</a>
                            <button class="btn btn-danger" title="Hapus" onclick="event.preventDefault();(confirm('Data Pajak & Services yang sudah dihapus tidak dapat dikembalikan! \nLanjutkan? ') ? document.getElementById('deleteTax').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus</button>
                            <form action="{{ url('/tax/' . $taxes->tax_id) }}" id="deleteTax" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
