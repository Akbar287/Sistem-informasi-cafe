@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/stock/out') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/stock/out') }}">{{ $title }}</a></li>
        <li class="breadcrumb-item active">Lihat {{ $title }}</li>
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
                            <h2 class="mb-3 line-head">Lihat {{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-10">
                        <div class="form-group row">
                            <label for="outlet" class="control-label col-md-3">Outlet</label>
                            <div class="col-md-8">
                                <select name="outlet" disabled class="custom-select" id="outlet">
                                    <option value="{{ $stock->outlet_id }}">{{ $stock->name }}</option>
                                </select>
                                @error('outlet')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time" class="control-label col-md-3">Tanggal</label>
                            <div class="col-md-8">
                                <input class="form-control" disabled value="{{ date_format($stock->created_at, 'Y-m-d') . 'T' . date_format($stock->created_at, 'H:i:s') }}" type="datetime-local" name="time" id="time">
                                @error('time')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="control-label col-md-3">Catatan</label>
                            <div class="col-md-8">
                                <textarea name="description" disabled id="description" class="form-control" rows="5">{{ $stock->description }}</textarea>
                                @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="stock-in-create-table">
                                <thead>
                                    <th width="20%">Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Satuan</th>
                                    <th>Harga Beli / Unit</th>
                                    <th>Total Harga Beli</th>
                                </thead>
                                <tbody>
                                @if(!is_null($products) && !empty($products)) @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>Rp. {{ number_format($product->total, 2, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($product->quantity * $product->total, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @else
                                <p>No Data</p>
                                @endif
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th colspan="4"><p class="text-right">Grand Total</p></th>
                                        <td id="grand-total">Rp. <span>{{ number_format($total, 2, ',', '.') }}</span></td>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 justify-content-center">
                    <div class="col-12 col-sm-12 col-md-12 text-center">
                        <div class="btn-group">
                            <a href="{{ url('stock/out') }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" disabled class="btn btn-primary" title="Tambah Stok"><i class="fa fa-edit"></i> Ubah Stok Masuk</button>
                            <button type="button" class="btn btn-danger" title="Hapus Stok" onclick="event.preventDefault();(confirm('Data Stok Keluar akan dihapus!\nSetelah dihapus data tidak dapat dikembalikan. \nLanjutkan? ') ? document.getElementById('deleteStockOut').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus {{ $title }}</button>
                            <form action="{{ url('/stock/out/' . $stock->stock_card_id) }}" id="deleteStockOut" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
