@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/material') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/category') }}">{{$title}}</a></li>
        <li class="breadcrumb-item active">Lihat {{ $title }}</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Bahan Mentah</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-stock-tab" data-toggle="pill" href="#pills-stock" role="tab" aria-controls="pills-stock" aria-selected="false">Stock</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row justify-content-center mt-3">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center mb-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <img src="{{ asset('/images/material/' .$material->cover) }}" alt="Foto Bahan Mentah" width="300" height="150" class="img img-thumbnail img-fluid img-category">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <th>Nama Bahan Mentah</th>
                                                <td><p>{{ $material->title }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Harga</th>
                                                <td><p>Rp {{ number_format($material->price, 2, ",", '.') }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Satuan Unit</th>
                                                <td><p>{{ $material->unit }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Stok</th>
                                                <td>{{ $totalStock }} Stok</td>
                                            </tr>
                                            <tr>
                                                <th>Deskripsi</th>
                                                <td><p>{{ $material->description }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Peringatan Stok</th>
                                                <td><p>{{ ($material->isAlertStock == 1) ? "Aktif" : "Tidak Aktif" }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Manajemen Stok</th>
                                                <td><p>{{ ($material->isManageStock == 1) ? "Aktif" : "Tidak Aktif" }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Aktifkan Bahan Mentah</th>
                                                <td><p>{{ ($material->isActive == 1) ? "Aktif" : "Tidak Aktif" }}</p></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="btn-group mt-5">
                                    <a href="{{ url('/material') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    <a class="btn btn-primary" href="{{ url('/material/' . $material->material_id . '/edit') }}" title="Ubah Kategori"><i class="fa fa-pencil"></i> Ubah Bahan Mentah</a>
                                    <button class="btn btn-danger" title="Hapus Bahan Mentah" onclick="event.preventDefault();(confirm('Data Bahan Mentah akan dihapus! Semua Stok, Purchase order yang bersangkutan dengan bahan ini akan hilang! \nLanjutkan? ') ? document.getElementById('deletematerial').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus Bahan Mentah</button>
                                    <form action="{{ url('/material/' . $material->material_id) }}" id="deletematerial" method="POST">@csrf @method('delete')</form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
                        <h3>Total Stok: {{ $totalStock }}</h3>
                        <table class="table table-hover" id="stock-edit-table">
                            <thead>
                                <tr>
                                    <th>Outlet</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                <tr>
                                    <td>{{ $stock['name'] }}</td>
                                    <td>{{ $stock['stock'] }}</td>
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
@endsection
