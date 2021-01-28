@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-shopping-basket"></i> {{ $title }}</h1>
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
                            <a href="{{ url('/purchase/create') }}" class="btn btn-primary float-right">Tambah Data</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover" id="purchase-table">
                            <thead>
                                <th>Kode</th>
                                <th>Supplier</th>
                                <th>Outlet</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchases)
                                <tr>
                                    <td>{{ $purchases->code }}</td>
                                    <td>{{ $purchases->supplier }}</td>
                                    <td>{{ $purchases->outlet }}</td>
                                    <td>{{ $purchases->isStatus }}</td>
                                    <td><a class="btn btn-primary" href="{{ url('/purchases/'. $purchases->purchase_order_id) }}" title="Lihat Detil"><i class="fa fa-info"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
