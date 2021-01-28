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
        <li class="breadcrumb-item active">Tambah Variant</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <form action="{{ url('/product/' . $product->product_id . '/varian') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Tambah Varian Produk {{ $product->title }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            @if(count($variant) > 0)
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="imageSelect" class="control-label col-md-3">Gambar</label>
                                        <div class="col-md-8">
                                            <select name="imageSelect" class="custom-select" id="imageSelect">
                                                <option value="0" selected>Gambar Sendiri</option>
                                                @foreach($variant as $var)
                                                <option value="{{ $var->product_variation_id }}">{{ $var->title }}</option>
                                                @endforeach
                                            </select>
                                            <small id="imageSelect" class="form-text text-muted">
                                                Pilih Gambar Sendiri jika Beda Gambar dan Nama Varian untuk Gambar yang sama dengan varian terpilih
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="input-group mb-3" id="img-preview-create">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Unggah</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image-preview">
                                            <label class="custom-file-label" for="image-preview">Pilih Gambar</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <img src="" alt="Gambar Produk Varian" width="300" height="150" class="img img-thumbnail img-fluid img-variant" style="display: none;">
                                </div>
                                <div class="col-8 text-center m-2">
                                    <button class="btn btn-danger btn-block btn-times-image-variant" style="display: none;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="form-group row">
                                <label for="variant" class="control-label col-md-3">Varian Berdasarkan</label>
                                <div class="col-md-8">
                                    <select name="variant" id="variant" class="custom-select">
                                        @foreach($variantOption as $vo)
                                        <option value="{{ $vo->variant_name }}">{{ $vo->variant_name . ' ('. $vo->variant_option .') ' }}</option>
                                        @endforeach
                                    </select>
                                    @error('variant')<div id="variant" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="control-label col-md-3">Nama Varian Produk</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror " name="title" id="title">
                                    @error('title')<div id="title" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weight" class="control-label col-md-3">Berat</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('weight') }}" class="form-control @error('weight') is-invalid @enderror " name="weight" id="weight">
                                    @error('weight')<div id="weight" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="length" class="control-label col-md-3">Dimensi</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="length" value="{{ old('length') }}" name="length" placeholder="Panjang" class="form-control">
                                        <input type="text" value="{{ old('width') }}" name="width" placeholder="Lebar" class="form-control">
                                        <input type="text" value="{{ old('height') }}" name="height" placeholder="Tinggi" class="form-control">
                                    </div>
                                    @error('length')<div id="weight" class="invalid-feedback">{{ $message }}</div>@enderror
                                    @error('width')<div id="weight" class="invalid-feedback">{{ $message }}</div>@enderror
                                    @error('height')<div id="weight" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="control-label col-md-3">Harga</label>
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror " name="price" id="price">
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                    <small id="price" class="form-text text-muted">
                                        Tidak perlu memasukan titik atau koma
                                    </small>
                                    @error('price')<div id="price" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sku" class="control-label col-md-3">SKU</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('sku') }}" class="form-control @error('sku') is-invalid @enderror " name="sku" id="sku">
                                    @error('sku')<div id="sku" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="barcode" class="control-label col-md-3">Barcode</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('barcode') }}" class="form-control @error('barcode') is-invalid @enderror " name="barcode" id="barcode">
                                    @error('barcode')<div id="barcode" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isAlertStock" class="control-label col-md-3">Peringatan Stok</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('isAlertStock') }}" class="form-control @error('isAlertStock') is-invalid @enderror " name="isAlertStock" id="isAlertStock">
                                    <small id="isAlertStock" class="form-text text-muted">
                                        Peringatan akan muncul diberanda ketika stok sudah diangka tersebut.
                                    </small>
                                    @error('isAlertStock')<div id="isAlertStock" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="isManageStock" id="isManageStock">
                                    <label class="custom-control-label" for="isManageStock">Manajemen Stok</label>
                                    @error('isManageStock')<div id="isManageStock" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="isSale" id="isSale">
                                    <label class="custom-control-label" for="isSale">Dijual</label>
                                    @error('isSale')<div id="isSale" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="{{ url('/product/' . $product->product_id) }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Tambah Varian Produk</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
