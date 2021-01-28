@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/supplier/'. $supplier->supplier_id) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/supplier') }}">Supplier</a></li>
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
                            <h2 class="mb-3 line-head">Ubah Data Supplier</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form action="{{ url('/supplier/' . $supplier->supplier_id) }}" method="POST" class="form-horizontal"> @csrf @method('put')
                            <div class="form-group row">
                                <label for="company" class="control-label col-md-3">Nama Perusahaan</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $supplier->company }}" class="form-control @error('company') is-invalid @enderror " name="company" id="company">
                                    @error('company')<div id="company" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="control-label col-md-3">Nama Pegawai / Perwakilan</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $supplier->name }}" class="form-control @error('name') is-invalid @enderror " name="name" id="name">
                                    @error('name')<div id="name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_number" class="control-label col-md-3">Nomor Telepon / HP</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $supplier->phone_number }}" class="form-control @error('phone_number') is-invalid @enderror " name="phone_number" id="phone_number">
                                    @error('phone_number')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input type="email" value="{{ $supplier->email }}" class="form-control @error('email') is-invalid @enderror " name="email" id="email">
                                    @error('email')<div id="email" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="control-label col-md-3">Alamat</label>
                                <div class="col-md-8">
                                    <textarea name="address" id="address" rows="5" class="form-control @error('address') is-invalid @enderror ">{{ $supplier->address }}</textarea>
                                    @error('address')<div id="address" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="taxSupplier" class="control-label col-md-3">Pajak Supplier</label>
                                <div class="col-md-8">
                                    @if(!empty($taxes))
                                    <select name="taxSupplier[]" multiple="multiple" id="taxSupplier" style="width: 100%" class="select-tax-outlet form-control custom-select @error('taxSupplier') is-invalid @enderror">
                                        @foreach($taxes as $tax)
                                        <option value="{{ $tax->tax_id }}" {{ (in_array($tax->tax_id, $taxSupplier)) ? 'selected' : '' }}>{{ $tax->name }} ({{ intVal($tax->total) }} %)</option>
                                        @endforeach
                                    </select>
                                    @error('taxSupplier')<div id="taxSupplier" class="invalid-feedback">{{ $message }}</div>@enderror
                                    @else
                                    <select name="taxSupplier[]" disabled multiple="multiple" id="taxSupplier" style="width: 100%" class="select-tax-outlet form-control custom-select @error('taxSupplier') is-invalid @enderror"></select>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('/supplier/' . $supplier->supplier_id) }}" class="btn btn-info" type="button" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                                        <button class="btn btn-primary" type="submit" title="Ubah Data"><i class="fa fa-pencil"></i> Ubah  Data Supplier</button>
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
