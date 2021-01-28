@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/promo/voucher/' . $voucher['voucher_id']) }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/promo') }}">Voucher</a></li>
        <li class="breadcrumb-item active">Ubah Voucher</li>
    </ul>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-sm-12 col-md-10 col-lg-10">
        <div class="tile">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h2 class="mb-3 line-head">Ubah Voucher</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="{{ url('/promo/voucher/' . $voucher['voucher_id']) }}" method="POST">@csrf @method('put')
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3">Nama Promo</label>
                            <div class="col-md-8">
                                <input type="text" value="{{ $voucher['name'] }}" class="form-control @error('name') is-invalid @enderror " name="name" id="name">
                                @error('name')<div id="name" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code" class="control-label col-md-3">Kode Voucher</label>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="text" value="{{ $voucher['code'] }}" readonly class="form-control @error('code') is-invalid @enderror" name="code" id="code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="refresh-code-voucher"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Berisi Angka dan Abjad Random 16 Karakter.</small>
                                @error('code')<div id="code" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="isType" class="control-label col-md-3">Besar Diskon</label>
                            <div class="col-3 col-sm-3 col-md-2">
                                <select name="isType" name="isType" class="form-control @error('isType') is-invalid @enderror " id="isType">
                                    <option value="0" {{ ($voucher['isType'] == 1) ? '' : 'selected' }}>Rp.</option>
                                    <option value="1" {{ ($voucher['isType'] == 1) ? 'selected' : '' }}>%</option>
                                </select>
                                @error('isType')<div id="isType" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-9 col-sm-9 col-md-6">
                                <input type="text" value="{{ $voucher['discount'] }}" class="form-control @error('discount') is-invalid @enderror " name="discount" id="discount">
                                @error('discount')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="outlets" class="control-label col-md-3">Berlaku di Outlet</label>
                            <div class="col-md-8">
                                @if(!empty($outlets))
                                <select name="outlets[]" multiple="multiple" id="outlets" style="width: 100%" class="select-promo-outlet form-control custom-select @error('outlets') is-invalid @enderror">
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet['outlet_id'] }}" {{ (in_array($outlet->outlet_id, $outletVoucher)) ? 'selected' : '' }}>{{ $outlet['name'] }}</option>
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
                                    <option value="0" {{ ($voucher['isActive'] == 1) ? '' : 'selected' }}>Tidak Aktif</option>
                                    <option value="1"{{ ($voucher['isActive'] == 1) ? 'selected' : '' }}>Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="control-label col-md-3">Waktu</label>
                            <div class="col-md-8">
                                <div class="input-group input-daterange">
                                    <input type="text" name="start_date" class="form-control" value="{{ $voucher['start_date'] }}">
                                    <div class="input-group-addon">Sampai</div>
                                    <input type="text" name="end_date" class="form-control" value="{{ $voucher['end_date'] }}">
                                </div>
                                @error('start_date')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                                @error('end_date')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="control-label col-md-3">Deskripsi</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ $voucher['description'] }}</textarea>
                                @error('description')<div id="discount" class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-8 text-center">
                                <button type="submit" class="btn btn-primary" title="Simpan Perubahan"><i class="fa fa-edit"></i> Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
