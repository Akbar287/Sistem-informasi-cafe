@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-cubes"></i> {{ $title }}</h1>
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
                            <a href="{{ url('/material/create') }}" class="btn btn-primary float-right">Tambah Bahan Mentah</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover" id="material-table">
                            <thead>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </thead>
                            <tbody>
                                @foreach($materials as $material)
                                <tr>
                                    <td>{{ $material->material_id }}</td>
                                    <td>{{ $material->title }}</td>
                                    <td>Rp. {{ number_format($material->price, 2, ',', '.') }}</td>
                                    <td>{{ ($material->isActive) ? 'Aktif' : 'Tidak' }}</td>
                                    <td><a class="btn btn-primary btn-sm" href="{{ url('/material/'. $material->material_id) }}" title="Lihat Detil"><i class="fa fa-info"></i></a></td>
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
