@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-building"></i> {{ $title }}</h1>
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
                            <h2 class="mb-3 line-head float-left">Daftar Outlet</h2>
                            <a href="{{ url('/outlet/create') }}" class="btn btn-primary float-right">Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover" id="outlet-table">
                            <thead>
                                <th>Outlet</th>
                                <th>Kota</th>
                                <th>Telepon</th>
                                <th>Pajak</th>
                                <th>Detail</th>
                            </thead>
                            <tbody>
                                @foreach($outlets as $outlet)
                                <tr>
                                    <td>{{ $outlet->name }}</td>
                                    <td>{{ $outlet->city }}</td>
                                    <td>{{ $outlet->phone_number }}</td>
                                    <td>{{ ($tax[$outlet->outlet_id]) ? 'Ada' : 'Tidak' }}</td>
                                    <td><a class="btn btn-primary btn-sm" href="{{ url('/outlet/'. $outlet->outlet_id) }}" title="Lihat Detil"><i class="fa fa-info"></i></a></td>
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
