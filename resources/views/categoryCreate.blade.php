@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/category') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/category') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah {{ $title }}</li>
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
                                <a class="nav-link active" id="category-tab" href="{{ url('/category') }}" aria-controls="category" aria-selected="false">Kategori</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="product-tab" href="{{ url('/product') }}" aria-controls="product-pill" aria-selected="true">Produk</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="{{ url('/category') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="input-group mb-3" id="img-preview-create">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Unggah</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image-preview">
                                            <label class="custom-file-label" for="image-preview">Pilih Gambar Kategori</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <img src="" alt="Foto Profil" width="300" height="150" class="img img-thumbnail img-fluid img-category" style="display: none;">
                                </div>
                                <div class="col-8 text-center m-2">
                                    <button class="btn btn-danger btn-block btn-times-image-category" style="display: none;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="form-group row">
                                <label for="title" class="control-label col-md-3">Nama Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror " name="title" id="title">
                                    @error('title')<div id="title" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="control-label col-md-3">Deskripsi</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror ">{{ old('description') }}</textarea>
                                    @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Tambah Kategori</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
