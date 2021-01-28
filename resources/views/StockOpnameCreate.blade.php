@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/stock/opname') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/stock/opname') }}">{{ $title }}</a></li>
        <li class="breadcrumb-item active">Tambah {{ $title }}</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Tambah {{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <form action="{{ url('/stock/opname') }}" method="post">@csrf
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-10">
                            <div class="form-group row">
                                <label for="outlet" class="control-label col-md-3"> Outlet</label>
                                <div class="col-md-8">
                                    <select name="outlet" class="custom-select" id="outlet">
                                        <option value="0">Pilih Outlet</option>
                                        @foreach($outlets as $outlet)
                                        <option value="{{ $outlet->outlet_id }}">{{ $outlet->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('byOutlet')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="control-label col-md-3">Catatan</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover" id="stock-opname-create-table">
                                    <thead>
                                        <th width="20%">Produk</th>
                                        <th>Jumlah Barang(Sistem)</th>
                                        <th>Jumlah Barang(Aktual)</th>
                                        <th>Satuan</th>
                                        <th>Simpangan</th>
                                        <th>Harga per Unit(Sistem)</th>
                                        <th>Harga per Unit(Baru)</th>
                                    </thead>
                                    <tbody id="tbody-stock-opname"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center notify">
                        <div class="col-12 text-center">
                            <p>Pilih Outlet Terlebih dahulu!</p>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 col-md-12 col-lg-6 text-center">
                            <div class="btn-group btn-option-table" style="display: none">
                                <button class="btn btn-sm btn-primary" id="stock-addTable" type="button"><i class="fa fa-plus"></i> Tambah Produk</button>
                                <button class="btn btn-danger btn-sm" id="stock-removeTable" type="button"><i class="fa fa-trash"></i> Hapus Baris</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 col-sm-12 col-md-12 text-center">
                            <div class="btn-group">
                                <a href="{{ url('stock/transfer') }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary" title="Tambah Stok"><i class="fa fa-pencil"></i> Tambah {{ $title }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
