@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-home"></i> Dashboard</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item active">Home</li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
                <a href="{{ url('/customer') }}" style="text-decoration: none;color: black;"><h4>Pelanggan</h4></a>
                <p><b>{{ $widget['customers'] }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-dollar fa-3x"></i>
            <div class="info">
                <a href="{{ url('/report') }}" style="text-decoration: none;color: black;"><h4>Transaksi</h4></a>
                <p><b>{{ $widget['transactions'] }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-building fa-3x"></i>
            <div class="info">
                <a href="{{ url('/outlet') }}" style="text-decoration: none;color: black;"><h4>Outlet</h4></a>
                <p><b>{{ $widget['outlets'] }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-th-list fa-3x"></i>
            <div class="info">
                <a href="{{ url('/product') }}" style="text-decoration: none;color: black;"><h4>Produk</h4></a>
                <p><b>{{ $widget['products'] }}</b></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card my-2">
            <div class="card-header">
                <h3 class="card-title">Sebaran Outlet</h3>
            </div>
            <div class="card-body">
                <div id="map_canvas" style="width:100%;height:400px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card my-2">
            <div class="card-header">
                <h3 class="card-title">Stok Akan Habis</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Nama</th>
                        <th>Stok</th>
                    </thead>
                    <tbody>
                        <td colspan="2">Tidak Ada Stok Habis</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
