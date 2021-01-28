@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/tax') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/tax') }}"></a> Pajak & Services</li>
        <li class="breadcrumb-item active">Tambah</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-8">
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">Tambah {{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <form action="{{ url('/tax') }}" method="POST" class="form-horizontal"> @csrf
                            <div class="form-group row">
                                <label for="name" class="control-label col-md-3">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror " name="name" id="name">
                                    @error('name')<div id="name" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="control-label col-md-3">Tipe</label>
                                <div class="col-md-8">
                                    <select name="type" id="type" class="custom-select @error('type') is-invalid @enderror ">
                                        @foreach($type as $tax_type)
                                        <option value="{{$tax_type->tax_type_id}}">{{$tax_type->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('type')<div id="phone_number" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total" class="control-label col-md-3">Total</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" value="{{ old('total') }}" class="form-control @error('total') is-invalid @enderror " name="total" id="total">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    @error('total')<div id="total" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="outlet" class="control-label col-md-3">Outlet</label>
                                <div class="col-md-8">
                                    <select name="outlet[]" id="outlet" class="custom-select select-tax-outlet @error('outlet') is-invalid @enderror" multiple>
                                        @foreach($outlet as $myOutlet)
                                        <option value="{{$myOutlet->outlet_id}}">{{$myOutlet->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('outlet')<div id="outlet" class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit" title="Tambah Data"><i class="fa fa-pencil"></i> Tambah</button>
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
