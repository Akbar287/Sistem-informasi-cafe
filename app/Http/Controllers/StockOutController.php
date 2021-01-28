<?php

namespace App\Http\Controllers;

use App\Helper\CodeMaker;
use App\LogHistory;
use App\Outlet;
use App\ProductStock;
use App\ProductVariation;
use App\StockCards;
use App\StockProductOutlet;
use App\TransferStockOutlet;
use App\TypeStock;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
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
        $toDate = (!is_null($request->toDate)) ? $toDate : Date('Y-m-d');
        $title = 'Stok Keluar';
        $stockOut = StockCards::select('stock_cards.stock_card_id')->addSelect('stock_cards.created_at')->addSelect('stock_cards.code_id')->addSelect('type_stock.name')->addSelect('outlet.name')->join('type_stock', 'stock_cards.type_stock_id', 'type_stock.type_stock_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->join('outlet', 'transfer_stock_outlet.byOutlet_id', 'outlet.outlet_id')->where('type_stock.name', 'Stok Keluar')->whereBetween('stock_cards.created_at', [$fromDate, $toDate. ' 23:59:59'])->orderBy('stock_cards.created_at', 'desc')->get();
        return view('StockOut', compact('title', 'stockOut', 'fromDate', 'toDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Stok Keluar';
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        return view('StockOutCreate', compact('title', 'outlets'));
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
            'time' => 'required',
            'description' => 'required',
        ]);

        if(count($request->product) > 0) {

            for($i=0; $i < count($request->product); $i++) {
                $oldStock = StockProductOutlet::select('stock_outlet.stock as stock_outlet')->addSelect('stock_outlet.stock_outlet_id')->addSelect('product_variation.stock as stock_all')->join('product_variation', 'product_variation.product_variation_id', 'stock_outlet.product_variation_id')->where('stock_outlet.product_variation_id', $request->product[$i])->where('stock_outlet.outlet_id', $request->outlet)->first();
                if(($oldStock->stock_outlet - $request->quantity[$i]) < 0 && ($oldStock->stock_all - $request->quantity[$i] < 0)) {
                    return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stok Keluar gagal Didata! Pastikan stok akhir tidak kurang dari 0<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            }
            $date = new DateTime($request->time);
            $date = $date->format('Y-m-d H:i:s');
            $type_stock = TypeStock::select('type_stock_id')->where('name', 'Stok Keluar')->first();

            $outlet = new TransferStockOutlet();
            $outlet->byOutlet_id = $request->outlet;
            $outlet->toOutlet_id = $request->outlet;
            $outlet->save();

            $stock_cards = new StockCards();
            $stock_cards->type_stock_id = $type_stock->type_stock_id;
            $stock_cards->transfer_stock_outlet_id = $outlet->transfer_stock_outlet_id;
            $stock_cards->code_id = CodeMaker::codeMaker('SK', 'Stok Keluar');
            $stock_cards->description = $request->description;
            $stock_cards->created_at = $date;
            $stock_cards->save();

            for($i=0; $i < count($request->product); $i++) {
                DB::table('product_stock')->insert([
                    'stock_card_id' => $stock_cards->stock_card_id,
                    'product_variation_id' => $request->product[$i],
                    'quantity' => $request->quantity[$i],
                    'total' => $request->pricePerUnit[$i],
                    'created_at' => Date('Y-m-d H:i:s'),
                    'updated_at' => Date('Y-m-d H:i:s')
                    ]);

                $oldStock = StockProductOutlet::select('stock_outlet.stock as stock_outlet')->addSelect('stock_outlet.stock_outlet_id')->addSelect('product_variation.stock as stock_all')->join('product_variation', 'product_variation.product_variation_id', 'stock_outlet.product_variation_id')->where('stock_outlet.product_variation_id', $request->product[$i])->where('stock_outlet.outlet_id', $request->outlet)->first();
                if(($oldStock->stock_outlet - $request->quantity[$i]) >= 0 && ($oldStock->stock_all - $request->quantity[$i] >= 0)) {
                    $stock = StockProductOutlet::find($oldStock->stock_outlet_id);
                    $stock->stock = $oldStock->stock_outlet - $request->quantity[$i];
                    $stock->save();

                    $variation = ProductVariation::find($request->product[$i]);
                    $variation->stock = $oldStock->stock_all - $request->quantity[$i];
                    $variation->save();
                } else {
                    return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stok Keluar gagal Didata! Pastikan stok akhir tidak kurang dari 0<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            }

            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Stok Keluar';
            $history->className = 'StockOutController';
            $history->functionName = 'store';
            $history->description = 'Mengeluarkan Stok Produk Variasi dengan id Stock Card: ' . $stock_cards->stock_card_id;
            $history->ip_address = $request->ip();
            $history->save();

            if($stock_cards->stock_card_id) {
                return redirect('/stock/out')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Stok Keluar berhasil Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stok Keluar gagal Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Isi produk Stok Keluar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $title = 'Stok Keluar';
        $stock = StockCards::select('stock_cards.stock_card_id')->addSelect('stock_cards.created_at')->addSelect('stock_cards.description')->addSelect('type_stock.name as type')->addSelect('outlet.outlet_id')->addSelect('stock_cards.code_id')->addSelect('type_stock.name')->addSelect('outlet.name')->join('type_stock', 'stock_cards.type_stock_id', 'type_stock.type_stock_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->join('outlet', 'transfer_stock_outlet.byOutlet_id', 'outlet.outlet_id')->where('stock_cards.stock_card_id', $id)->first();
        $products = ProductStock::select('product_stock.*')->addSelect('unit.name as unit')->addSelect(DB::raw('CONCAT(products.title, " ", product_variation.title) as title'))->join('product_variation', 'product_variation.product_variation_id', 'product_stock.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->join('unit', 'products.unit', 'unit.unit_id')->where('stock_card_id', $id)->get();
        $total = 0;
        foreach($products as $product) {
            $total += ($product->quantity * $product->total);
        }
        return view('StockOutShow', compact('title', 'stock', 'products', 'total'));
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
        return redirect('/stock/out')->with('msg', '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Keluar tidak Dihapus. Hubungi administrator!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;die();
        $stock_cards = StockCards::find($id);
        if($stock_cards) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Stok Keluar';
            $history->className = 'StockOutController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Stok Keluar dengan id ' . $stock_cards->stock_card_id;
            $history->ip_address = $request->ip();
            $history->save();

            ProductStock::where('stock_card_id', $id)->delete();
            TransferStockOutlet::where('transfer_stock_outlet_id', $stock_cards->transfer_stock_outlet_id)->delete();

            if($stock_cards->delete()) {
                return redirect('/stock/out')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Stock Keluar berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Keluar gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/stock/out')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Keluar ID tidak ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
}
