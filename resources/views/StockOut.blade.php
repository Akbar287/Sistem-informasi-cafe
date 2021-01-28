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
                            <h2 class="mb-3 line-head float-left">{{ $title }}</h2>
                            <a href="{{ url('/stock/out/create') }}" class="btn btn-primary float-right" title="Tambah Stok"><i class="fa fa-plus"></i> Tambah {{ $title }}</a>
                        </div>
                    </div>
                </div>
                <form action="{{ url('/stock/in') }}" method="get">@csrf
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
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
                                <th>Kode</th>
                                <th>Outlet</th>
                                <th>Waktu</th>
                                <th>Detil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($stockOut) && !empty($stockOut)) @foreach($stockOut as $stock)
                            <tr>
                                <td>{{ $stock->code_id }}</td>
                                <td>{{ $stock->name }}</td>
                                <td>{{ date_format($stock->created_at, "d/m/Y H:i") }}</td>
                                <td><a href="{{ url('/stock/out/' . $stock->stock_card_id) }}" class="btn btn-sm btn-primary"><i class="fa fa-info"></i></a></td>
                            </tr>
                            @endforeach
                            @else
                            <tr colspan="4"><td><p>No Data</p></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
