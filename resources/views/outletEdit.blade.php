@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/outlet/'.$outlet->outlet_id) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/outlet') }}">Outlet</a></li>
        <li class="breadcrumb-item active">Ubah Data</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8">
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Data Outlet</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form action="{{ url('/outlet/'. $outlet->outlet_id) }}" method="POST" class="form-horizontal"> @csrf @method('put')
                            <div class="form-group row">
                                <label for="name" class="control-label col-md-3">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $outlet->name }}" class="form-control @error('name') is-invalid @enderror " name="name" id="name">
                                    @error('name')<div id="name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_number" class="control-label col-md-3">Nomor Telepon / HP</label>
                                <div class="col-md-8">
                                    <input type="text" name="phone_number" id="phone_number" value="{{ $outlet->telephone }}" class="form-control @error('phone_number') is-invalid @enderror">
                                    @error('phone_number')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="control-label col-md-3">Kota</label>
                                <div class="col-md-8">
                                    <input type="text" name="city" id="city" value="{{ $outlet->city }}" class="form-control @error('city') is-invalid @enderror">
                                    @error('city')<div id="address" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="control-label col-md-3">Alamat</label>
                                <div class="col-md-8">
                                    <textarea name="address" id="address" rows="5" class="form-control @error('address') is-invalid @enderror ">{{ $outlet->address }}</textarea>
                                    @error('address')<div id="address" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="taxOutlet" class="control-label col-md-3">Pajak & Services</label>
                                <div class="col-md-8">
                                    @if(!empty($taxes))
                                    <select name="taxOutlet[]" multiple="multiple" id="taxOutlet" style="width: 100%" class="select-tax-outlet form-control custom-select @error('taxOutlet') is-invalid @enderror">
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->tax_id }}" {{ (in_array($tax->tax_id, $taxOutlet)) ? 'selected' : '' }}>{{ $tax->name }} ({{ intVal($tax->total) }} %)</option>
                                        @endforeach
                                    </select>
                                    @error('taxOutlet')<div id="taxOutlet" class="invalid-feedback">{{ $message }}</div>@enderror
                                    @else
                                    <select name="taxOutlet[]" disabled multiple="multiple" id="taxOutlet" style="width: 100%" class="select-tax-outlet form-control custom-select @error('taxOutlet') is-invalid @enderror"></select>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-10 col-md-12 col-lg-8 text-center">
                                    <div id="maps" style="width: 100%; height: 400px;border: 1px solid black"></div>
                                    <input type="hidden" name="lat" value="{{ $outlet->lat }}" class="form-control" id="lat_location">
                                    <input type="hidden" name="lng" value="{{ $outlet->lng }}" class="form-control" id="lng_location">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-10 col-md-8 text-left">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" {{ ($outlet->isTable == 1) ? 'checked' : '' }} class="custom-control-input" id="isTable" name="isTable">
                                        <label class="custom-control-label" for="isTable">Modul Meja</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-10 col-md-8 text-left">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" {{ ($outlet->isActive == 1) ? 'checked' : '' }} class="custom-control-input" id="isActive" name="isActive">
                                        <label class="custom-control-label" for="isActive">Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('/outlet/' .$outlet->outlet_id) }}" class="btn btn-info" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                                        <button class="btn btn-primary" type="submit" title="Ubah Data"><i class="fa fa-edit"></i> Ubah Outlet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
