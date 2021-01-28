@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/category/' . $category->category_id) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/category') }}">Kategori</a></li>
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
                                <a class="nav-link active" id="category-tab" href="{{ url('/category') }}" aria-controls="category" aria-selected="false">Kategori</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="product-tab" href="{{ url('/product') }}" aria-controls="product-pill" aria-selected="true">Produk</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="{{ url('/category/' . $category->category_id) }}" method="POST" enctype="multipart/form-data">@csrf @method('put')
                    <div class="row justify-content-center mt-3">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <img src="{{ asset('/images/category/' .$category->cover) }}" alt="Foto Profil" width="300" height="150" class="img img-thumbnail img-fluid img-category">
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <div class="custom-file" id="image-preview-edit-div">
                                        <input type="file" class="custom-file-input" id="image-preview-edit" name="image" lang="id">
                                        <label class="custom-file-label" for="imageCategory">Pilih Gambar</label>
                                    </div>
                                </div>
                                <div class="col-8 text-center m-2">
                                    <button class="btn btn-info btn-block btn-times-image-category" style="display: none;"><i class="fa fa-undo"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="form-group row">
                                <label for="title" class="control-label col-md-3">Nama Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $category->title }}" class="form-control @error('title') is-invalid @enderror " name="title" id="title">
                                    @error('title')<div id="title" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="control-label col-md-3">Deskripsi</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror ">{{ $category->description }}</textarea>
                                    @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="btn-group">
                                <a href="{{ url('/category/'.$category->category_id) }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Ubah Kategori</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
