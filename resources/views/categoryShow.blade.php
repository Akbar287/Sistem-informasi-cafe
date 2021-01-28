@extends('layouts.app')

@section('content')
<div class="app-title">
    <div>
        <h1><a href="{{ url('/category') }}" class="btn"><i class="fa fa-arrow-left"></i></a> {{ $title }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/category') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Lihat {{ $title }}</li>
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
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center mb-2">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <img src="{{ asset('/images/category/' .$category->cover) }}" alt="Foto Profil" width="300" height="150" class="img img-thumbnail img-fluid img-category">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <td><p>{{ $category->title }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>Produk</th>
                                        <td>
                                            @if(!empty($products)) <ul> @foreach($products as $product)
                                                <li>{{ $product['title'] }}</li>
                                            @endforeach </ul> @else
                                            <p>Tidak Ada Produk</p>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td><p>{{ $category->description }}</p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-group mt-5">
                            <a href="{{ url('/category') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <a class="btn btn-primary" href="{{ url('/category/' . $category->category_id . '/edit') }}" title="Ubah Kategori"><i class="fa fa-pencil"></i> Ubah Kategori</a>
                            <button class="btn btn-danger" title="Hapus Kategori" onclick="event.preventDefault();(confirm('Data Kategori akan dihapus! namun produk yang ada di kategori tersebut tidak akan hilang tapi akan terindeks [Tidak Terkategori]! \nLanjutkan? ') ? document.getElementById('deleteCategory').submit() : event.preventDefault() );"><i class="fa fa-trash"></i> Hapus Kategori</button>
                            <form action="{{ url('/category/' . $category->category_id) }}" id="deleteCategory" method="POST">@csrf @method('delete')</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
