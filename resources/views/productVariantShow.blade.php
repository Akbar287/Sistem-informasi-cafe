@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/product/' . $product->product_id) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product') }}">{{ $title }}</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product/' . $product->product_id) }}">Lihat {{ $title }}</a></li>
        <li class="breadcrumb-item active">Lihat Variant</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Lihat Varian Produk {{ $product->title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-3">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <img src="{{ asset('images/products/'.$variant->cover) }}" alt="Gambar Produk Varian" width="300" height="150" class="img img-thumbnail img-fluid img-variant">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Varian Berdasarkan</th>
                                        <td>{{ $variant->variation_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Varian</th>
                                        <td>{{ $variant->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Berat</th>
                                        <td>{{ $variant->weight }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensi</th>
                                        <td>{{ $variant->length . ' x ' . $variant->width . ' x ' . $variant->height }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>Rp. {{ number_format($variant->price, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>SKU</th>
                                        <td>{{ $variant->sku }}</td>
                                    </tr>
                                    <tr>
                                        <th>Barcode</th>
                                        <td>{{ $variant->barcode }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stok Tersedia</th>
                                        <td>@if($variant->isAlertStock > $variant->stock) <p style="color: red;">{{ $variant->stock }}</p>@else<p> {{ $variant->stock }}</p>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Peringatan Stok</th>
                                        <td>{{ $variant->isAlertStock }}</td>
                                    </tr>
                                    <tr>
                                        <th>Manajemen Stok</th>
                                        <td>{{ ($variant->isManageStock == 1) ? 'Aktif' : 'Tidak' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dijual</th>
                                        <td>{{ ($variant->isSale == 1) ? 'Aktif' : 'Tidak' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-group">
                            <a href="{{ url('/product/' . $product->product_id ) }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ url('/product/' . $product->product_id . '/varian/' . $variant->product_variation_id. '/edit') }}" class="btn btn-primary" title="Ubah Varian Produk"><i class="fa fa-pencil"></i> Ubah Varian Produk</a>
                            <button class="btn btn-danger" title="Hapus" title="Hapus Varian Produk" onclick="event.preventDefault();(confirm('Data Varian Produk akan dihapus! \nLanjutkan? ') ? document.getElementById('deleteVariantProduct').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus</button>
                            <form action="{{ url('/product/' . $product->product_id . '/varian/' . $variant->product_variation_id) }}" id="deleteVariantProduct" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
