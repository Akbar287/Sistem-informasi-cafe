<?php

namespace App\Http\Controllers;

use App\Helper\CodeMaker;
use App\LogHistory;
use App\Outlet;
use App\Products;
use App\ProductStock;
use App\ProductVariation;
use App\ProductVariationRelation;
use App\StockCards;
use App\StockProductOutlet;
use App\TransferStockOutlet;
use App\TypeStock;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockTransferController extends Controller
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
        $title = 'Stok Transfer';
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
        $stockTransfer = json_decode(StockCards::select('stock_cards.stock_card_id')->addSelect('stock_cards.created_at')->addSelect('stock_cards.code_id')->addSelect('type_stock.name')->addSelect('transfer_stock_outlet.byOutlet_id')->addSelect('transfer_stock_outlet.toOutlet_id')->join('type_stock', 'stock_cards.type_stock_id', 'type_stock.type_stock_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->where('type_stock.name', 'Transfer Stok')->whereBetween('stock_cards.created_at', [$fromDate , $toDate. ' 23:59:59'])->orderBy('stock_cards.created_at', 'desc')->get(), true);
        $outlets = json_decode(Outlet::select('name')->addSelect('outlet_id')->get(), true);
        for($i=0;$i < count($stockTransfer); $i++) {
            for($j=0;$j< count($outlets); $j++) {
                if($outlets[$j]['outlet_id'] == $stockTransfer[$i]['byOutlet_id']) {
                    $stockTransfer[$i]['byOutlet_id'] = $outlets[$j]['name'];
                }
                if($outlets[$j]['outlet_id'] == $stockTransfer[$i]['toOutlet_id']) {
                    $stockTransfer[$i]['toOutlet_id'] = $outlets[$j]['name'];
                }
            }
            $date = new DateTime($stockTransfer[$i]['created_at']);$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $stockTransfer[$i]['created_at'] = $date->format('d/m/Y H:i');
        }
        $toDate = (!is_null($request->toDate)) ? $toDate : Date('Y-m-d');
        return view('StockTransfer', compact('title', 'stockTransfer', 'fromDate', 'toDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Stok Transfer';
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        return view('StockTransferCreate', compact('title', 'outlets'));
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
            'byOutlet' => 'required|numeric',
            'toOutlet' => 'required|numeric',
            'description' => 'required',
            'time' => 'required',
        ]);
        $date = new DateTime($request->time);
        $date = $date->format('Y-m-d H:i:s');

        //Validation Time
        if ((time() - strtotime($date)) <= 0 ){
            return redirect('/stock/transfer/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Waktu tidak boleh melebihi Hari Ini!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
        }
        //Validation Product
        if(count($request->product) <= 0) {
            return redirect('/stock/transfer/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Isi produk Stok Transfer!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
        }
        //Validation Product Stock
        for($i=0;$i < count($request->product); $i++) {
            $re = (StockProductOutlet::select('stock_outlet.stock as stock_outlet')->addSelect('stock_outlet.stock_outlet_id')->addSelect('product_variation.stock as stock_all')->selectRaw('CONCAT(products.title," ", product_variation.title) as title')->join('product_variation', 'product_variation.product_variation_id', 'stock_outlet.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->where('stock_outlet.product_variation_id', $request->product[$i])->where('stock_outlet.outlet_id', $request->byOutlet)->first());
            if($re->stock > $request->quantity[$i]) {
                return redirect('/stock/transfer/create')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stok Tersedia produk '. $re->title .' di outlet asal tidak boleh minus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
            }
        }
        $type_stock = TypeStock::select('type_stock_id')->where('name', 'Transfer Stok')->first();

        $transfer_outlet = new TransferStockOutlet();
        $transfer_outlet->byOutlet_id = $request->byOutlet;
        $transfer_outlet->toOutlet_id = $request->toOutlet;
        $transfer_outlet->save();

        $stock_cards = new StockCards();
        $stock_cards->type_stock_id = $type_stock->type_stock_id;
        $stock_cards->transfer_stock_outlet_id = $transfer_outlet->transfer_stock_outlet_id;
        $stock_cards->code_id = CodeMaker::codeMaker('TS', 'Transfer Stok');
        $stock_cards->description = $request->description;
        $stock_cards->created_at = $date;
        $stock_cards->save();

        for($i=0; $i < count($request->product); $i++) {
            DB::table('product_stock')->insert([
                'stock_card_id' => $stock_cards->stock_card_id,
                'product_variation_id' => $request->product[$i],
                'quantity' => $request->quantity[$i],
                'total' => 0,
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s')
            ]);

            $oldStockByOutlet = StockProductOutlet::select('stock')->where('product_variation_id', $request->product[$i])->where('outlet_id', $request->byOutlet)->first();
            $oldStockToOutlet = StockProductOutlet::select('stock')->where('product_variation_id', $request->product[$i])->where('outlet_id', $request->toOutlet)->first();
            StockProductOutlet::where('outlet_id', $request->byOutlet)->where('product_variation_id', $request->product[$i])->update(['stock'=> ($oldStockByOutlet->stock - intval($request->quantity[$i]))]);
            StockProductOutlet::where('outlet_id', $request->toOutlet)->where('product_variation_id', $request->product[$i])->update(['stock'=> ($oldStockToOutlet->stock + intval($request->quantity[$i]))]);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Transfer Stok';
        $history->className = 'StockTransferController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Transfer Stok Produk Variasi dengan id Stock Card: ' . $stock_cards->stock_card_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($stock_cards->stock_card_id) {
            return redirect('/stock/transfer')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Transfer Stok berhasil Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/stock/transfer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Transfer Stok gagal Didata!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $title = 'Stok Transfer';
        $stock = StockCards::select('stock_cards.stock_card_id')->addSelect('stock_cards.created_at')->addSelect('stock_cards.description')->addSelect('type_stock.name as type')->addSelect('stock_cards.code_id')->addSelect('type_stock.name')->addSelect('transfer_stock_outlet.byOutlet_id')->addSelect('transfer_stock_outlet.toOutlet_id')->join('type_stock', 'stock_cards.type_stock_id', 'type_stock.type_stock_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->where('stock_cards.stock_card_id', $id)->first();
        $products = ProductStock::select('product_stock.*')->addSelect('unit.name as unit')->addSelect(DB::raw('CONCAT(products.title, " ", product_variation.title) as title'))->join('product_variation', 'product_variation.product_variation_id', 'product_stock.product_variation_id')->join('product_variation_relation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->join('products', 'products.product_id', 'product_variation_relation.product_id')->join('unit', 'products.unit', 'unit.unit_id')->where('stock_card_id', $id)->get();
        $outlets = Outlet::select('outlet_id')->addSelect('name')->get();
        $outlet = ['from' => '', 'to' => ''];
        for($i=0;$i < count($outlets); $i++) {
            $outlet['from'] = ($outlets[$i]['outlet_id'] == $stock['byOutlet_id']) ? $outlets[$i]['name'] : $outlet['from'];
            $outlet['to'] = ($outlets[$i]['outlet_id'] == $stock['toOutlet_id']) ? $outlets[$i]['name'] : $outlet['to'];
        }
        $time = date("Y-m-d\TH:i", strtotime($stock['created_at']));
        return view('StockTransferShow', compact('title', 'stock', 'products', 'outlets', 'outlet', 'time'));
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
        return redirect('/stock/transfer')->with('msg', '<div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Transfer tidak Dihapus. Hubungi administrator!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;die();
        $stock_cards = StockCards::find($id);
        if($stock_cards) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Stok Transfer';
            $history->className = 'StockTransferController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Stok Transfer dengan id ' . $stock_cards->stock_card_id;
            $history->ip_address = $request->ip();
            $history->save();

            ProductStock::where('stock_card_id', $id)->delete();
            TransferStockOutlet::where('transfer_stock_outlet_id', $stock_cards->transfer_stock_outlet_id)->delete();

            if($stock_cards->delete()) {
                return redirect('/stock/transfer')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Stock Transfer berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/stock/transfer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Transfer gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/stock/transfer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Stock Transfer ID tidak ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function getCustomData(Request $request)
    {
        $fromDate = Date('Y-m-01');
        $toDate = Date('Y-m-d H:i:s');
        if($request->data) {
            $date = ($request->data) ? explode('&', $request->data): 0;
            if(!is_null($date['0'])) {
                $fromDate = explode('=', $date['0'])['1'];
            }
            if(!is_null($date['1'])) {
                $toDate = explode('=', $date['1'])['1'];
            }
        }
        $stockTransfer = json_decode(StockCards::select('stock_cards.created_at')->addSelect('stock_cards.code_id')->addSelect('transfer_stock_outlet.byOutlet_id')->addSelect('transfer_stock_outlet.toOutlet_id')->join('type_stock', 'stock_cards.type_stock_id', 'type_stock.type_stock_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->where('type_stock.name', 'Transfer Stok')->whereBetween('stock_cards.created_at', [$fromDate , $toDate])->orderBy('stock_cards.created_at', 'desc')->get(), true);
        $outlets = json_decode(Outlet::select('name')->addSelect('outlet_id')->get(), true);
        for($i=0;$i < count($stockTransfer); $i++) {
            for($j=0;$j< count($outlets); $j++) {
                if($outlets[$j]['outlet_id'] == $stockTransfer[$i]['byOutlet_id']) {
                    $stockTransfer[$i]['byOutlet_id'] = $outlets[$j]['name'];
                }
                if($outlets[$j]['outlet_id'] == $stockTransfer[$i]['toOutlet_id']) {
                    $stockTransfer[$i]['toOutlet_id'] = $outlets[$j]['name'];
                }
            }
            $date = new DateTime($stockTransfer[$i]['created_at']);$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $stockTransfer[$i]['created_at'] = $date->format('d/m/Y H:i');
        }
        return response()->json([
            'status' => true,
            'message' => 'success to get Data',
            'data' => $stockTransfer
        ], 200);
    }
    public function getProductData(Request $request)
    {
        $relations = json_decode(ProductVariationRelation::select('product_id')->addSelect('product_variation_relation.product_variation_id')->join('product_variation', 'product_variation_relation.product_variation_id', 'product_variation.product_variation_id')->where('product_variation.isManageStock', 1)->get(), true);
        $temp = [];
        $products = json_decode(Products::select('product_id')->addSelect('title')->addSelect('unit.name as unit')->join('unit', 'unit.unit_id', 'products.unit')->get(), true);
        $Variations = json_decode(ProductVariation::select('product_variation_id')->addSelect('title')->get(), true);
        for($i=0;$i < count($relations); $i++) {
            $stock = StockProductOutlet::select('stock')->where('product_variation_id', $Variations[$relations[$i]['product_variation_id'] - 1]['product_variation_id'])->where('outlet_id', $request->by_outlet)->first();
            $temp[] = [
                'product_id' => $products[$relations[$i]['product_id'] - 1]['product_id'],
                'product_variation_id' => $Variations[$relations[$i]['product_variation_id'] - 1]['product_variation_id'],
                'title' => $products[$relations[$i]['product_id'] - 1]['title'] . ' - ' . $Variations[$relations[$i]['product_variation_id'] - 1]['title'],
                'satuan' => $products[$relations[$i]['product_id'] -1]['unit'],
                'stock' => $stock->stock
            ];
        }unset($relations, $products, $Variations);
        return response()->json([
            'status' => true,
            'message' => 'Success to get products variant',
            'data' => $temp
        ], 200);exit;
    }
}
