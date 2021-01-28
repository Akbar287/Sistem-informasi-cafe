@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/material') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/material') }}">{{ $title }}</a></li>
        <li class="breadcrumb-item active">Ubah {{ $title }}</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <form action="{{ url('/material') }}" method="POST" enctype="multipart/form-data">@csrf
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Data Bahan Mentah</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-stock-tab" data-toggle="pill" href="#pills-stock" role="tab" aria-controls="pills-stock" aria-selected="false">Stok</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                                                <label class="custom-file-label" for="image-preview">Pilih Gambar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <img src="" alt="Foto Profil" width="300" height="150" class="img img-thumbnail img-fluid img-material" style="display: none;">
                                    </div>
                                    <div class="col-8 text-center m-2">
                                        <button class="btn btn-danger btn-block btn-times-image-material" style="display: none;"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                <div class="form-group row">
                                    <label for="title" class="control-label col-md-3">Nama Bahan Mentah</label>
                                    <div class="col-md-8">
                                        <input type="text" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror " name="title" id="title">
                                        @error('title')<div id="title" class="invalid-feedback">{{ $message }}</div>@enderror
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
                                        @error('price')<div id="price" class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="unit" class="control-label col-md-3">Satuan Unit</label>
                                    <div class="col-md-8">
                                        <select name="unit" class="custom-select" id="unit">
                                            @foreach($units as $unit)
                                            <option value="{{ $unit->unit_id }}">{{ $unit->name . " (" . $unit->short . ")" }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="control-label col-md-3">Deskripsi</label>
                                    <div class="col-md-8">
                                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror ">{{ old('description') }}</textarea>
                                        @error('description')<div id="description" class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="isAlertStock" id="isAlertStock">
                                        <label class="custom-control-label" for="isAlertStock">Peringatan Stok</label>
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
                                        <input type="checkbox" class="custom-control-input" name="isActive" id="isActive">
                                        <label class="custom-control-label" for="isActive">Aktifkan Stok</label>
                                        @error('isActive')<div id="isActive" class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ url('/material') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Tambah Bahan mentah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-stock" role="tabpanel" aria-labelledby="pills-stock-tab">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-12 com-md-10">
                                <table class="table table-hover" id="stock-edit-table">
                                    <thead>
                                        <th>Outlet</th>
                                        <th>Stok</th>
                                    </thead>
                                    <tbody>
                                        @foreach($outlets as $outlet)
                                        <tr>
                                            <td><label for="stock-{{$outlet->outlet_id}}">{{ $outlet->name }}</label></td>
                                            <td><input type="number" value="0" class="form-control @error('stock') is-invalid @enderror stock-edit" name="stock[{{$outlet->outlet_id}}]" id="stock-{{$outlet->outlet_id}}">
                                            @error('stock')<div id="stock" class="invalid-feedback">{{ $message }}</div>@enderror</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
