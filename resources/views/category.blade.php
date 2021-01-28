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
                    <div class="col-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="category-tab" href="{{ url('/category') }}" aria-controls="category" aria-selected="false">Kategori</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="product-tab" href="{{ url('/product') }}" aria-controls="product-pill" aria-selected="true">Produk</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 text-center">
                        <a href="{{ url('/category/create') }}" class="btn btn-primary" title="Tambah Kategori"><i class="fa fa-pencil"></i> Tambah Kategori</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="category-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah Produk</th>
                                <th>Detil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>{{ $productCount[$category->category_id] }}</td>
                                <td>
                                    <a href="{{ url('/category/' . $category->category_id) }}" class="btn btn-sm btn-primary" title="Lihat Detil"><i class="fa fa-info"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
