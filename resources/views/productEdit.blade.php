@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/product') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product') }}">Produk</a></li>
        <li class="breadcrumb-item active">Ubah {{ $title }}</li>
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
                <form action="{{ url('/product/' . $product->product_id) }}" method="POST">@csrf @method('put')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <h2 class="mb-3 line-head">Ubah Produk</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group row">
                                <label for="title" class="control-label col-md-3">Nama Produk</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $product->title }}" class="form-control @error('title') is-invalid @enderror " name="title" id="title">
                                    @error('title')<div id="title" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="unit" class="control-label col-md-3">Satuan Unit</label>
                                <div class="col-md-8">
                                    <select name="unit" class="custom-select" id="unit">
                                        @foreach($units as $unit)
                                        <option value="{{ $unit->unit_id }}" {{ ($unit->unit_id == $product->unit) ? 'selected' : '' }}>{{ $unit->name . " (" . $unit->short . ")" }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isActive" class="control-label col-md-3">Status Aktif</label>
                                <div class="col-md-8">
                                    <select name="isActive" class="custom-select" id="isActive">
                                        <option {{ ($product->isActive == 0) ? 'selected' : '' }} value="0">Tidak Aktif</option>
                                        <option {{ ($product->isActive == 1) ? 'selected' : '' }} value="1">Aktif</option>
                                    </select>
                                    @error('isActive')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group row">
                                <label for="category" class="control-label col-md-3">Kategori</label>
                                <div class="col-md-8">
                                    <select name="category" class="custom-select" id="category">
                                        <option value="0">Tidak Terkategori</option>
                                        @if(isset($categories) && !is_null($categories)) @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ ($this_category == $category->category_id) ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach @endif
                                    </select>
                                    @error('category')<div id="category" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="control-label col-md-3">Deskripsi</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror ">{{ $product->description }}</textarea>
                                    @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Ubah Produk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
