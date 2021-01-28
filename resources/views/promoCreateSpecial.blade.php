@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/promo') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/promo') }}">Promo</a></li>
        <li class="breadcrumb-item active">Tambah Promo</li>
    </ul>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10">
        <div class="tile">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h2 class="mb-3 line-head">Tambah Promo Spesial</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ url('/promo/special') }}" method="POST">@csrf
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3">Nama Promo</label>
                            <div class="col-md-8">
                                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror " name="name" id="name">
                                @error('name')<div id="name" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isType" class="control-label col-md-3">Besar Diskon</label>
                            <div class="col-3 col-sm-3 col-md-2">
                                <select name="isType" name="isType" class="form-control @error('isType') is-invalid @enderror " id="isType">
                                    <option value="0">Rp.</option>
                                    <option value="1">%</option>
                                </select>
                                @error('isType')<div id="isType" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-9 col-sm-9 col-md-6">
                                <input type="text" value="{{ old('discount') }}" class="form-control @error('discount') is-invalid @enderror " name="discount" id="discount">
                                @error('discount')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="outlets" class="control-label col-md-3">Berlaku di Outlet</label>
                            <div class="col-md-8">
                                @if(!empty($outlets))
                                <select name="outlets[]" multiple="multiple" id="outlets" style="width: 100%" class="select-promo-outlet form-control custom-select @error('outlets') is-invalid @enderror">
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet['outlet_id'] }}">{{ $outlet['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('outlets')<div id="outlets" class="invalid-feedback">{{ $message }}</div>@enderror
                                @else
                                <select name="outlets[]" disabled multiple="multiple" id="outlets" style="width: 100%" class="select-tax-outlet form-control custom-select @error('outlets') is-invalid @enderror"></select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isActive" class="control-label col-md-3">Aktifkan Promo</label>
                            <div class="col-md-8">
                                <select id="isActive" name="isActive" class="custom-select @error('isActive') is-invalid @enderror">
                                    <option value="0">Tidak Aktif</option>
                                    <option value="1">Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="control-label col-md-3">Waktu</label>
                            <div class="col-md-8">
                                <div class="input-group input-daterange">
                                    <input type="text" name="start_date" class="form-control" value="{{ date("m/d/Y") }}">
                                    <div class="input-group-addon">Sampai</div>
                                    <input type="text" name="end_date" class="form-control" value="{{ date("m/d/Y") }}">
                                </div>
                                @error('start_date')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                                @error('end_date')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-8 text-center">
                                <button type="submit" class="btn btn-primary" title="Simpan Promo"><i class="fa fa-pencil"></i> Simpan Promo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
