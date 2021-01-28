@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-truck"></i> {{ $title }}</h1>
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
                            <h2 class="mb-3 line-head float-left">Daftar Supplier</h2>
                            <a href="{{ url('/supplier/create') }}" class="btn btn-primary float-right">Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover" id="supplier-table">
                            <thead>
                                <th>ID</th>
                                <th>Nama Usaha</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Detil</th>
                            </thead>
                            <tbody>
                                @foreach($supplier as $supply)
                                <tr>
                                    <td>{{ $supply->supplier_id }}</td>
                                    <td>{{ $supply->company }}</td>
                                    <td>{{ $supply->address }}</td>
                                    <td>{{ $supply->phone_number }}</td>
                                    <td>{{ $supply->email }}</td>
                                    <td><a class="btn btn-primary btn-sm" href="{{ url('/supplier/'. $supply->supplier_id) }}" title="Lihat Detail"><i class="fa fa-info"></i></a></td>
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
