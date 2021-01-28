@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ul>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            @if(session('msg')) {!! session('msg') !!} @endif
            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h2 class="mb-3 line-head">{{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <form action="{{ url('/stock/card') }}" method="get">@csrf
                    <div class="form-group row justify-content-center">
                        <div class="col-12 col-sm-12 py-2 col-md-3">
                            <select name="outlet" id="" class="custom-select">
                                <option value="0">Semua Outlet</option>
                                @if(!is_null($outlets) && !empty($outlets)) @foreach($outlets as $outlet)
                                <option value="{{ $outlet->outlet_id }}" {{ ($outlet->outlet_id == $outletID) ? 'selected': '' }}>{{ $outlet->name }}</option>
                                @endforeach @endif
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 py-2 col-md-3">
                            <select name="category" id="" class="custom-select">
                                <option value="0">Semua Kategori</option>
                                @if(!is_null($categories) && !empty($categories)) @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->title }}</option>
                                @endforeach @endif
                                <option value="0">Tidak Terkategori</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 py-2 col-md-6">
                            <div class="input-group input-daterange">
                                <input class="form-control" type="date" value="{{ $fromDate }}" name="fromDate" id="fromDate">
                                <div class="input-group-addon px-2">-</div>
                                <input class="form-control" type="date" value="{{ $toDate }}" name="toDate" id="toDate">
                                <button class="btn btn-primary btn-sm mx-2" type="submit"><i class="fa fa-check"></i></button>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover" id="stock-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Stok Awal</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Penjualan</th>
                                <th>Transfer</th>
                                <th>Penyesuaian</th>
                                <th>Stok Akhir</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($products) && !empty($products)) @foreach($products as $product)
                            <tr>
                                <td>{{ $product['title'] }}</td>
                                <td>{{ $product['option']['first'] }}</td>
                                <td>{{ $product['option']['in'] }}</td>
                                <td>{{ $product['option']['out'] }}</td>
                                <td>{{ $product['option']['sales'] }}</td>
                                <td>{{ $product['option']['transfer'] }}</td>
                                <td>{{ $product['option']['opname'] }}</td>
                                <td>{{ $product['lastStock'] }}</td>
                                <td>{{ $product['unit'] }}</td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
