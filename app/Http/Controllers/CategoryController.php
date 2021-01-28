<?php

namespace App\Http\Controllers;

use App\Category;
use App\LogHistory;
use App\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Kategori';
        $categories = Category::all();
        $temp = [];
        if(!empty($categories)) {
            foreach($categories as $category) {
                $temp[$category->category_id] = DB::table('category_product')->where('category_id', $category->category_id)->count();
            }
        }
        $productCount = $temp;unset($temp);
        return view('category', compact('title', 'productCount', 'categories'));
    }
    public function create()
    {
        $title = 'Kategori';
        return view('categoryCreate', compact('title'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $image = 'nophoto.png';

        if(!is_null($request->file('image'))){
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/category/', $oldImage);
            $image = $oldImage;
        }

        $category = new Category();
        $category->title = $request->title;
        $category->cover = $image;
        $category->description = $request->description;
        $category->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Kategori Produk';
        $history->className = 'CategoryController';
        $history->functionName = 'store';
        $history->description = 'Menambah Kategori Produk id ' . $category->category_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($category->category_id) {
            return redirect('/category')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Kategori Produk berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/category')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Kategori Produk gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Kategori';
        $products = json_decode(Products::select('title')->join('category_product', 'category_product.product_id', 'products.product_id')->where('category_product.category_id', $id)->get(), true);
        $category = Category::where('category_id', $id)->first();
        return view('categoryShow', compact('title', 'category', 'products'));
    }
    public function edit($id)
    {
        $title = 'Kategori';
        $category = Category::where('category_id', $id)->first();
        return view('categoryEdit', compact('title', 'category'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $category = Category::find($id);

        $oldImage = $category->cover;

        if(!is_null($request->file('image'))){
            if (!is_null($oldImage)) {
                if($oldImage != 'nophoto.png'){
                    File::delete(public_path() . '/images/category/' . $oldImage);
                }
            }
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/category/', $oldImage);
        }


        $category->title = $request->title;
        $category->cover = $oldImage;
        $category->description = $request->description;
        $category->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Kategori Produk';
        $history->className = 'CategoryController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Kategori Produk id ' . $category->category_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($category->category_id) {
            return redirect('/category')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Kategori Produk berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/category')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Kategori Produk gagal Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);
        if($request) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Kategori Produk';
            $history->className = 'CategoryController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Kategori Produk id ' . $category->category_id;
            $history->ip_address = $request->ip();
            $history->save();

            $oldImage = $category->cover;
            if (!is_null($oldImage)) {
                if($oldImage != 'nophoto.png'){
                    File::delete(public_path() . '/images/category/' . $oldImage);
                }
            }

            DB::table('category_product')->where('category_id', $id)->delete();
            if($category->delete()) {
                return redirect('/category')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Kategori Produk berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/category')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Kategori Produk gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/category')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Kategori Produk Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    private function imgRandom($img)
    {
        $img = (explode('.', $img));
        $ekstensi = $img[count($img) - 1];
        unset($img[count($img) - 1]);
        $img = implode('.', $img) . '.' . time() . '.' . $ekstensi;
        return $img;
    }
}
