@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/product') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product') }}">Produk</a></li>
        <li class="breadcrumb-item active">Lihat {{ $title }}</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="category-tab" href="{{ url('/category') }}" aria-controls="category" aria-selected="false">Kategori</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="product-tab" href="{{ url('/product') }}" aria-controls="product-pill" aria-selected="true">Produk</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Lihat Produk</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $category }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <td>{{ $product->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Satuan Unit</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Aktif</th>
                                        <td>{{ $product->isActive == 1 ? 'Aktif' : 'Tidak' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Varian</th>
                                        <td>{{ count($variants) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $product->description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="btn-group">
                            <a href="{{ url('/product') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ url('/product/' . $product->product_id . '/edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Ubah Produk</a>
                            <button class="btn btn-danger" title="Hapus" onclick="event.preventDefault();(confirm('Data Produk akan dihapus! Termasuk Data Produk Varian didalamnya! \nLanjutkan? ') ? document.getElementById('deleteProduct').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus</button>
                            <form action="{{ url('/product/' . $product->product_id) }}" id="deleteProduct" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head float-left">Varian Produk</h2>
                            <a href="{{ url('/product/'. $product->product_id . '/varian') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Tambah Varian</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover" id="variant-product-table">
                                <thead>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Detail</th>
                                </thead>
                                <tbody>
                                    @foreach($variants as $variant)
                                    <tr>
                                        <td>{{ $variant['product_variation_id'] }}</td>
                                        <td>{{ $variant['title'] }}</td>
                                        <td>Rp. {{ number_format($variant['price'], 2, ',', '.') }}</td>
                                        <td>{{ $variant['stock'] }}</td>
                                        <td><a href="{{ url('/product/'. $product->product_id .'/varian/' . $variant['product_variation_id']) }}" class="btn btn-primary btn-sm" title="Detail"><i class="fa fa-info"></i></a></td>
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
</div>
@endsection
