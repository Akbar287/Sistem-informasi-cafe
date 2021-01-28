<?php

namespace App\Http\Controllers;

use App\Category;
use App\Dimensi;
use App\LogHistory;
use App\Outlet;
use App\Products;
use App\ProductVariation;
use App\ProductVariationRelation;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Produk';
        $products = Products::select('products.product_id')->addSelect('products.title')->addSelect('products.isActive')->get();
        $variant = json_decode(DB::table('product_variation_relation')->select('product_id')->addSelect(DB::raw("COUNT(product_variation_id) as variant"))->groupBy('product_id')->get(), true);
        $temp = [];$arr = [];
        foreach($variant as $var) {
            $temp[$var['product_id']] = $var['variant'];
            $arr[] = $var['product_id'];
        }
        $variant = $temp;
        unset($temp);
        return view('products', compact('title', 'products', 'variant', 'arr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Produk';
        $units = DB::table('unit')->get();
        $categories = Category::select('category_id')->addSelect('title')->get();
        return view('productCreate', compact('title', 'units', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|numeric',
            'title' => 'required|unique:products,title',
            'unit' => 'required|numeric',
            'isActive' => 'required|numeric',
            'description' => 'required'
        ]);

        $product = new Products();
        $product->title = $request->title;
        $product->unit = $request->unit;
        $product->isActive = $request->isActive;
        $product->description = $request->description;
        $product->save();

        if($request->category != 0) {
            DB::table('category_product')->insert(['id' => null, 'category_id' => $request->category, 'product_id' => $product->product_id]);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Produk';
        $history->className = 'ProductController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Produk dengan id ' . $product->product_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($product->product_id) {
            return redirect('/product')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Produk Berhasil ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/product')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Produk gagal ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Produk';
        $product = Products::select('products.*')->addSelect('unit.name')->addSelect('unit.short')->join('unit', 'unit.unit_id', 'products.unit')->where('product_id', $id)->first();
        $category = Category::select('title')->join('category_product', 'category_product.category_id', 'category.category_id')->where('category_product.product_id', $id)->first();
        $category = (!is_null($category)) ? $category->title : 'Tidak Terkategori';
        $variants = json_decode(DB::table('product_variation_relation')->select('product_variation.product_variation_id')->addSelect('product_variation.product_variation_id')->addSelect('product_variation.price')->addSelect('product_variation.title')->addSelect('product_variation.stock')->addSelect('product_variation.cover')->join('product_variation', 'product_variation.product_variation_id', 'product_variation_relation.product_variation_id')->where('product_variation_relation.product_id', $id)->get(), true);
        return view('productShow', compact('title', 'product', 'variants', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Produk';
        $product = Products::select('products.*')->addSelect('unit.name')->addSelect('unit.short')->join('unit', 'unit.unit_id', 'products.unit')->where('product_id', $id)->first();
        $variant = json_decode(DB::table('product_variation_relation')->select('product_variation.product_variation_id')->addSelect('product_variation.product_variation_id')->addSelect('product_variation.price')->addSelect('product_variation.title')->addSelect('product_variation.stock')->addSelect('product_variation.cover')->join('product_variation', 'product_variation.product_variation_id', 'product_variation_relation.product_variation_id')->where('product_variation_relation.product_id', $id)->get(), true);
        $units = DB::table('unit')->get();
        $this_category = Category::select('category.category_id')->join('category_product', 'category_product.category_id', 'category.category_id')->where('category_product.product_id', $id)->first();
        $this_category = (!is_null($this_category)) ? $this_category->category_id : 0;
        $categories = Category::select('category_id')->addSelect('title')->get();
        return view('productEdit', compact('title', 'units', 'product', 'variant', 'categories', 'this_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Products::find($id);
        $validate = [
            'category' => 'required',
            'unit' => 'required|numeric',
            'isActive' => 'required|numeric',
            'description' => 'required'
        ];
        $validate['title'] = ($product->title == $request->title) ? 'required' : 'required|unique:products,title';
        $this->validate($request, $validate);

        $product->title = $request->title;
        $product->unit = $request->unit;
        $product->isActive = $request->isActive;
        $product->description = $request->description;
        $product->save();

        DB::table('category_product')->where('product_id', $id)->delete();
        if ($request->category != 0) {
            DB::table('category_product')->insert(['id' => null, 'product_id' => $id, 'category_id' => $request->category]);
        }
        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Produk';
        $history->className = 'ProductController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Produk dengan id ' . $product->product_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($product->product_id) {
            return redirect('/product/'. $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Produk Berhasil diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/product/'. $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Produk gagal diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Products::find($id);
        if($request) {
            $variants = ProductVariation::select('product_variation.product_variation_id')->addSelect('product_variation.cover')->where('product_variation_relation.product_id', $id)->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->get();dd($variants);
            $arr = '';
            foreach($variants as $variant) {
                $arr .= $variant->product_variation_id .' ';
                if (!is_null($variant->cover)) {
                    if($variant->cover != 'nophoto.png'){
                        File::delete(public_path() . '/images/pro/' . $variant->cover);
                    }
                }
                ProductVariation::where('product_variation_id', $variant->product_variation_id)->delete();
            }
            $cond = $product->delete();
            DB::table('product_variation_relation')->where('product_id', $id)->delete();
            DB::table('category_product')->where('product_id', $id)->delete();
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Bahan Mentah';
            $history->className = 'ProductController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Produk dengan id ' . $product->product_id . ' beserta varian dengan id ' . $arr;
            $history->ip_address = $request->ip();
            $history->save();

            if($cond) {
                return redirect('/material')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Produk beserta Varian Produk berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/material')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Produk beserta Varian Produk gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/material')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Produk Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function variantCreate(Request $request, $id)
    {
        $title = 'Produk';
        $product = Products::select('products.product_id')->addSelect('products.title')->addSelect('products.isActive')->where('product_id', $id)->first();
        $variantOption = DB::table('variant')->get();
        $variant = ProductVariation::select('product_variation.product_variation_id')->addSelect('product_variation.title')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->where('product_variation_relation.product_id', $id)->get();
        return view('productVariantCreate', compact('title', 'product', 'variant', 'variantOption'));
    }
    public function variantStore(Request $request, $id)
    {
        $this->validate($request, [
            'variant' => 'required',
            'title' => 'required|unique:product_variation,title',
            'weight' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'price' => 'required|numeric',
            'sku' => 'required',
            'barcode' => 'required',
            'isAlertStock' => 'required|numeric'
            ]);
        $image = 'nophoto.png';
        if($request->imageSelect == 0) {
            if(!is_null($request->file('image'))){
                $file = $request->file('image');
                $oldImage = $this->imgRandom($file->getClientOriginalName());
                $file->move(public_path() . '/images/products/', $oldImage);
                $image = $oldImage;
            }
        } else {
            $temp = ProductVariation::select('cover')->where('product_variation_id', $request->imageSelect)->first();
            $image = $temp->cover;unset($temp);
        }
        $dimension = new Dimensi();
        $dimension->length = $request->length;
        $dimension->width = $request->width;
        $dimension->height = $request->height;
        $dimension->save();

        $price = str_replace(',', '', $request->price);
        $price = str_replace('.', '', $price);

        $variant = new ProductVariation();
        $variant->title = $request->title;
        $variant->cover = $image;
        $variant->weight = $request->weight;
        $variant->dimension_id = $dimension->dimension_id;
        $variant->price = $price;
        $variant->stock = 0;
        $variant->sku = $request->sku;
        $variant->price = $request->price;
        $variant->barcode = $request->barcode;
        $variant->isAlertStock = $request->isAlertStock;
        $variant->isManageStock = !is_null($request->isManageStock) ? : 0;
        $variant->isSale = !is_null($request->isSale) ? 1 : 0;
        $variant->save();

        $variantID = $variant->product_variation_id;

        $relation = new ProductVariationRelation();
        $relation->product_id = $id;
        $relation->variation_name = $request->variant;
        $relation->product_variation_id = $variantID;
        $relation->save();

        $outlets = Outlet::select('outlet_id')->get();
        foreach($outlets as $outlet) {
            DB::table('stock_outlet')->insert([
                'product_variation_id' => $variant->product_variation_id,
                'outlet_id' => $outlet->outlet_id,
                'stock' => 0,
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            ]);
        }
        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Produk Variant';
        $history->className = 'ProductController';
        $history->functionName = 'store';
        $history->description = 'Menambah Variant Produk dengan id ' . $variantID . ' dengan produk ' . $id;
        $history->ip_address = $request->ip();
        $history->save();

        if($variantID) {
            return redirect('/product/'.$id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Varian Produk berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/product/'.$id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Varian Produk gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function variantShow($id, $var)
    {
        $title = 'Produk';
        $product = Products::select('products.product_id')->addSelect('products.title')->addSelect('products.isActive')->where('product_id', $id)->first();
        $variantOption = DB::table('variant')->get();
        $variant = ProductVariation::select('product_variation.*')->addSelect('dimension.*')->addSelect('product_variation_relation.variation_name')->join('dimension', 'product_variation.dimension_id', 'dimension.dimension_id')->join('product_variation_relation', 'product_variation.product_variation_id', 'product_variation_relation.product_variation_id')->where('product_variation.product_variation_id', $var)->first();
        return view('productVariantShow', compact('title', 'product', 'variant', 'variantOption'));
    }
    public function variantEdit($id, $var)
    {
        $title = 'Produk';
        $product = Products::select('products.product_id')->addSelect('products.title')->addSelect('products.isActive')->where('product_id', $id)->first();
        $variantOption = DB::table('variant')->get();
        $variants = $variant = ProductVariation::select('product_variation.product_variation_id')->addSelect('product_variation.title')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->where('product_variation_relation.product_id', $id)->get();
        $variant = ProductVariation::select('product_variation.*')->addSelect('dimension.*')->addSelect('product_variation_relation.variation_name')->join('dimension', 'product_variation.dimension_id', 'dimension.dimension_id')->join('product_variation_relation', 'product_variation.product_variation_id', 'product_variation_relation.product_variation_id')->where('product_variation.product_variation_id', $var)->first();
        return view('productVariantEdit', compact('title', 'product', 'variant', 'variants', 'variantOption'));
    }
    public function variantUpdate(Request $request, $id, $var)
    {
        $variant = ProductVariation::find($var);

        $validate = [
            'variant' => 'required',
            'weight' => 'required|numeric',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'price' => 'required|numeric',
            'sku' => 'required',
            'barcode' => 'required',
            'isAlertStock' => 'required|numeric'
        ];
        $validate['title'] = ($variant->title == $request->title) ? 'required' : 'required|unique:product_variation,title';
        $this->validate($request, $validate);

        $image = $variant->cover;
        if($request->imageSelect == 0) {
            if(!is_null($request->file('image'))){
                $oldImage = $variant->cover;
                if (!is_null($oldImage)) {
                    if($oldImage != 'nophoto.png'){
                        File::delete(public_path() . '/images/products/' . $oldImage);
                    }
                }
                $file = $request->file('image');
                $oldImage = $this->imgRandom($file->getClientOriginalName());
                $file->move(public_path() . '/images/products/', $oldImage);
                $image = $oldImage;
            }
        } else {
            $temp = ProductVariation::select('cover')->where('product_variation_id', $request->imageSelect)->first();
            $image = $temp->cover;unset($temp);
        }
        $dimension = Dimensi::find($variant->dimension_id);
        $dimension->length = $request->length;
        $dimension->width = $request->width;
        $dimension->height = $request->height;
        $dimension->save();

        $price = str_replace(',', '', $request->price);
        $price = str_replace('.', '', $price);

        $variant->title = $request->title;
        $variant->cover = $image;
        $variant->weight = $request->weight;
        $variant->dimension_id = $dimension->dimension_id;
        $variant->price = $price;
        $variant->sku = $request->sku;
        $variant->price = $request->price;
        $variant->barcode = $request->barcode;
        $variant->isAlertStock = $request->isAlertStock;
        $variant->isManageStock = !is_null($request->isManageStock) ? : 0;
        $variant->isSale = !is_null($request->isSale) ? 1 : 0;
        $variant->save();

        $variantID = $variant->product_variation_id;

        $relate = ProductVariationRelation::where('product_id', $id)->where('product_variation_id', $var)->first();
        $relation = ProductVariationRelation::find($relate->id);
        $relation->product_id = $relate->product_id;
        $relation->variation_name = $request->variant;
        $relation->product_variation_id = $relate->product_variation_id;
        $relation->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Produk Variant';
        $history->className = 'ProductController';
        $history->functionName = 'variantUpdate';
        $history->description = 'Mengubah Variant Produk dengan id ' . $variantID . ' dengan produk ' . $id;
        $history->ip_address = $request->ip();
        $history->save();

        if($variantID) {
            return redirect('/product/'.$id . '/varian/' . $var)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Varian Produk berhasil Diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/product/'.$id . '/varian/' . $var)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Varian Produk gagal Diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function variantDestroy(Request $request, $id, $var)
    {
        $variant = ProductVariation::find($var);
        if($variant) {
            if (!is_null($variant->cover)) {
                if($variant->cover != 'nophoto.png'){
                    if(ProductVariation::where('cover', $variant->cover)->count() == 1) {
                        File::delete(public_path() . '/images/products/' . $variant->cover);
                    }
                }
            }

            $dimension = Dimensi::find($variant->dimension_id);
            $dimension->delete();

            ProductVariationRelation::where('product_id', $id)->where('product_variation_id', $var)->delete();

            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Produk Varian';
            $history->className = 'ProductController';
            $history->functionName = 'varianDestroy';
            $history->description = 'Menghapus Variant Produk dengan id ' . $var . ' dengan produk ' . $id;
            $history->ip_address = $request->ip();
            $history->save();
            if($variant->delete()) {
                return redirect('/product/' . $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Varian Produk berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/product/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Varian Produk gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/product/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Varian Produk Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
