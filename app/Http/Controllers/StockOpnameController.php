<?php

namespace App\Http\Controllers;

use App\Helper\CodeMaker;
use App\LogHistory;
use App\Outlet;
use App\ProductOpname;
use App\Products;
use App\ProductVariation;
use App\ProductVariationRelation;
use App\StockCards;
use App\StockOpname;
use App\StockProductOutlet;
use App\TypeStock;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Stok Opname';
        $fromDate = Date('Y-m-01');
        $toDate = Date('Y-m-d H:i:s');
        if(!is_null($request->fromDate) && !is_null($request->toDate)) {
            $fromDate = $request->fromDate;
            $toDate = $request->toDate;
            if(strtotime($fromDate) > strtotime($toDate)) {
                $temp = $fromDate;
                $fromDate = $toDate;
                $toDate = $temp;
            }
        }
        $stockOpname = json_decode(StockOpname::select('stock_opname.code_id')->addSelect('stock_opname_id')->addSelect('stock_opname.created_at')->addSelect('outlet.name as outlet')->join('outlet', 'outlet.outlet_id', 'stock_opname.outlet_id')->whereBetween('stock_opname.created_at', [$fromDate , $toDate . ' 23:59:59'])->orderBy('stock_opname.created_at', 'desc')->get(), true);
        $toDate = (!is_null($request->toDate)) ? $toDate : Date('Y-m-d');
        $product = json_decode(DB::table('stock_opname_relation')->selectRaw('COUNT(product_variation_id) as count')->addSelect('stock_opname_id')->groupBy('stock_opname_id')->get(), true);
        for($i=0;$i < count($stockOpname); $i++) {
            for($j=0;$j < count($product); $j++) {
                if($stockOpname[$i]['stock_opname_id'] == $product[$j]['stock_opname_id']) {
                    $stockOpname[$i]['product'] = $product[$j]['count'];
                }
            }
            $date = new DateTime($stockOpname[$i]['created_at']);$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $stockOpname[$i]['created_at'] = $date->format('d/m/Y H:i');
        }
        return view('StockOpname', compact('title', 'stockOpname', 'product', 'fromDate', 'toDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Stok Opname';
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        return view('StockOpnameCreate', compact('title', 'outlets'));
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
            'outlet' => 'required|numeric',
            'description' => 'required',
        ]);
        if(count($request->product) <= 0) {
            return redirect('/stock/opname/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Isi produk Stok Opname!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
        }
        //Validation Stock Product
        for($i=0; $i < count($request->product); $i++) {
            $temp = StockProductOutlet::selectRaw('CONCAT(products.title, " ", product_variation.title) as title')->addSelect('stock_outlet.stock')->join('product_variation', 'product_variation.product_variation_id', 'stock_outlet.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->where('stock_outlet.product_variation_id', $request->product[$i])->where('outlet_id', $request->outlet)->first();
            if(($temp->stock == intval($request->jmlBrgAkt[$i])) || (intval($request->deviation[$i]) == 0)){
                return redirect('/stock/opname/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Simpangan di Variasi Produk '. $temp->title .' tidak boleh bernilai 0!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
            }
        }

        $stock_opname = new StockOpname();
        $stock_opname->outlet_id = $request->outlet;
        $stock_opname->code_id = CodeMaker::StockOpname('SO', 'Stok Opname');
        $stock_opname->description = $request->description;
        $stock_opname->save();

        $relation = [];
        for($i=0; $i < count($request->product); $i++) {
            $priceSis = join("", explode('.', $request->prcPerUntSis[$i], -1));
            $priceSis = str_replace(',', '', $priceSis);str_replace('.', '', $priceSis);
            $priceAkt = join("", explode('.', $request->prcPerUntAkt[$i], -1));
            $priceAkt = str_replace(',', '', $priceAkt);str_replace('.', '', $priceAkt);

            $product = new ProductOpname();
            $product->quantity_system = $request->jmlBrgSis[$i];
            $product->quantity_actual = $request->jmlBrgAkt[$i];
            $product->deviation = $request->deviation[$i];
            $product->price_system = $priceSis;
            $product->price_actual = $priceAkt;
            $product->save();

            $relation[] = [
                'stock_opname_id' => $stock_opname->stock_opname_id,
                'product_opname_id' => $product->product_opname_id,
                'product_variation_id' => $request->product[$i]
            ];

            $stock = StockProductOutlet::selectRaw('CONCAT(products.title, " ", product_variation.title) as title')->addSelect('stock_outlet.stock as outlet_stock')->addSelect('product_variation.stock as global_stock')->join('product_variation', 'product_variation.product_variation_id', 'stock_outlet.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->where('stock_outlet.product_variation_id', $request->product[$i])->where('outlet_id', $request->outlet)->first();
            $cond = (intval($request->jmlBrgAkt[$i]) - $stock->outlet_stock);
            StockProductOutlet::where('product_variation_id', $request->product[$i])->where('outlet_id', $request->outlet)->update(['stock' => intval($request->jmlBrgAkt[$i])]);
            ProductVariation::where('product_variation_id', $request->product[$i])->update(['stock' => $stock->global_stock + $cond]);

        }
        DB::table('stock_opname_relation')->insert($relation);

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Stok Opname';
        $history->className = 'StockOpnameController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Opname Stok Produk Variasi dengan id Stock Opname: ' . $stock_opname->stock_opname_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($stock_opname->stock_opname_id) {
            return redirect('/stock/opname')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Stok Opname berhasil Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/stock/opname')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stok Opname gagal Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $title = 'Stok Opname';
        $stock = json_decode(StockOpname::select('stock_opname.code_id')->addSelect('stock_opname.outlet_id')->addSelect('stock_opname.description')->addSelect('stock_opname_id')->addSelect('stock_opname.created_at')->addSelect('outlet.name as outlet')->join('outlet', 'outlet.outlet_id', 'stock_opname.outlet_id')->where('stock_opname.stock_opname_id', $id)->first(), true);
        $temp = DB::table('stock_opname_relation')->selectRaw('COUNT(product_variation_id) as count')->where('stock_opname_id', $id)->groupBy('stock_opname_id')->first();
        $stock['product'] = $temp->count;
        $products = ProductOpname::select('product_opname.*')->addSelect('unit.name as unit')->selectRaw('CONCAT(products.title, " - ", product_variation.title) as title')->join('stock_opname_relation', 'stock_opname_relation.product_opname_id', 'product_opname.product_opname_id')->join('product_variation', 'product_variation.product_variation_id', 'stock_opname_relation.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->join('unit', 'unit.unit_id', 'products.unit')->where('stock_opname_relation.stock_opname_id', $id)->get();
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        $date = new DateTime($stock['created_at']);$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $stock['created_at'] = $date->format('Y-m-d'). 'T' .$date->format('H:i');
        return view('StockOpnameShow', compact('title', 'stock', 'outlets', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        return redirect('/stock/opname')->with('msg', '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Opname tidak Dihapus. Hubungi administrator!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;die();
        $stock_opname = StockOpname::find($id);
        if($stock_opname) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Stok Opname';
            $history->className = 'StockOpnameController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Stok Opname dengan id ' . $stock_opname->stock_opname_id;
            $history->ip_address = $request->ip();
            $history->save();

            DB::table('product_opname')->join('stock_opname_relation', 'stock_opname_relation.product_opname_id', 'product_opname.product_opname_id')->where('stock_opname_relation.stock_opname_id',$id)->delete();
            DB::table('stock_opname_relation')->where('stock_opname_id', $id)->delete();

            if($stock_opname->delete()) {
                return redirect('/stock/opname')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Stock Opname berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/stock/opname')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Opname gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/stock/opname')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Opname ID tidak ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    public function getProductData(Request $request)
    {
        $variation = ProductVariation::selectRaw('CONCAT(products.title, " ", product_variation.title) as title')->addSelect('product_variation.price')->addSelect('product_variation.product_variation_id')->addSelect('unit.name as unit')->addSelect('stock_outlet.stock')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->join('unit', 'unit.unit_id', 'products.unit')->join('stock_outlet', 'stock_outlet.product_variation_id', 'product_variation.product_variation_id')->where('stock_outlet.outlet_id', $request->outlet)->get();
        return response()->json([
            'status' => true,
            'message' => 'Success to get products variant',
            'data' => $variation
        ], 200);exit;
    }
}
