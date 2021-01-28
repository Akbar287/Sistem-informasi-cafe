<?php

namespace App\Http\Controllers;

use App\Category;
use App\Outlet;
use App\Products;
use App\ProductVariation;
use App\StockCards;
use App\StockOpname;
use App\TypeStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Kartu Stok';
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
        if($request->outlet == 0) {
            $products = json_decode(Products::selectRaw('CONCAT(products.title, " ", product_variation.title) as title')->addSelect('product_variation.product_variation_id')->addSelect('unit.name as unit')->addSelect('product_variation.stock as lastStock')->join('product_variation_relation', 'product_variation_relation.product_id', 'products.product_id')->join('product_variation', 'product_variation.product_variation_id','product_variation_relation.product_variation_id')->join('unit', 'unit.unit_id', 'products.unit')->get(), true);
        } else {
            $products = json_decode(Products::selectRaw('CONCAT(products.title, " ", product_variation.title) as title')->addSelect('product_variation.product_variation_id')->addSelect('unit.name as unit')->addSelect('stock_outlet.stock as lastStock')->join('product_variation_relation', 'product_variation_relation.product_id', 'products.product_id')->join('product_variation', 'product_variation.product_variation_id','product_variation_relation.product_variation_id')->join('unit', 'unit.unit_id', 'products.unit')->join('stock_outlet', 'stock_outlet.product_variation_id', 'product_variation.product_variation_id')->where('stock_outlet.outlet_id', $request->outlet)->get(), true);
        }
        $options = []; $opnameTemp = [];
        foreach($products as $product) {
            if($request->outlet == 0) {
                $options[] = json_decode(StockCards::select('product_stock.quantity')->addSelect('type_stock.type_stock_id')->addSelect('type_stock.name as type')->addSelect('transfer_stock_outlet.byOutlet_id')->addSelect('product_variation.product_variation_id')->addSelect('transfer_stock_outlet.toOutlet_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->join('product_stock', 'product_stock.stock_card_id', 'stock_cards.stock_card_id')->join('type_stock', 'type_stock.type_stock_id', 'stock_cards.type_stock_id')->join('product_variation', 'product_variation.product_variation_id', 'product_stock.product_variation_id')->where('product_stock.product_variation_id', $product['product_variation_id'])->whereBetween('stock_cards.created_at', [$fromDate, $toDate . ' 23:59:59'])->orderBy('stock_cards.created_at', 'desc')->get(), true);
            } else {
                $options[] = json_decode(StockCards::select('product_stock.quantity')->addSelect('type_stock.type_stock_id')->addSelect('type_stock.name as type')->addSelect('transfer_stock_outlet.byOutlet_id')->addSelect('product_variation.product_variation_id')->addSelect('transfer_stock_outlet.toOutlet_id')->join('transfer_stock_outlet', 'transfer_stock_outlet.transfer_stock_outlet_id', 'stock_cards.transfer_stock_outlet_id')->join('product_stock', 'product_stock.stock_card_id', 'stock_cards.stock_card_id')->join('type_stock', 'type_stock.type_stock_id', 'stock_cards.type_stock_id')->join('product_variation', 'product_variation.product_variation_id', 'product_stock.product_variation_id')->where('product_stock.product_variation_id', $product['product_variation_id'])->whereBetween('stock_cards.created_at', [$fromDate, $toDate . ' 23:59:59'])->where(function($query) use ($request) { $query->where('transfer_stock_outlet.toOutlet_id', $request->outlet)->orWhere('transfer_stock_outlet.byOutlet_id', $request->outlet); })->orderBy('stock_cards.created_at', 'desc')->get(), true);
            }

            $opnameTemp[] = json_decode(StockOpname::select('product_opname.deviation')->addSelect('stock_opname_relation.product_variation_id')->addSelect('stock_opname.outlet_id')->join('stock_opname_relation', 'stock_opname_relation.stock_opname_id', 'stock_opname.stock_opname_id')->join('product_opname','product_opname.product_opname_id', 'stock_opname_relation.product_opname_id')->where('stock_opname_relation.product_variation_id', $product['product_variation_id'])->get(), true);
        }
        // dd($products, $options, $opnameTemp);

        $typeStock = TypeStock::select('type_stock_id')->addSelect('name')->get();
        for($i=0;$i < count($products); $i++) {
            $temp = ['in' => 0, 'out' => 0, 'transfer' => 0, 'opname' => 0];
            for($j=0;$j < count($options[$i]); $j++) {
                if(intval($options[$i][$j]['type_stock_id']) === 1) {
                    $temp['in'] += $options[$i][$j]['quantity'];
                }
                if(intval($options[$i][$j]['type_stock_id']) === 2) {
                    $temp['out'] += $options[$i][$j]['quantity'];
                }
                if(intval($options[$i][$j]['type_stock_id']) === 3) {
                    if($request->outlet === 0) {
                        $temp['transfer'] += 0;
                    } else {
                        if($options[$i][$j]['byOutlet_id'] == $request->outlet) {
                            $temp['transfer'] += (intval($options[$i][$j]['quantity'])* -1);
                        } else if($options[$i][$j]['toOutlet_id'] == $request->outlet) {
                            $temp['transfer'] += (intval($options[$i][$j]['quantity']));
                        } else {
                            $temp['transfer'] += 0;
                        }
                    }
                }
            }
            for($j=0;$j < count($opnameTemp[$i]); $j++) {
                $temp['opname'] += $opnameTemp[$i][$j]['deviation'];
            }
            $products[$i]['option'] = $temp;
        }
        for($i=0;$i < count($products); $i++) {
            $temp = (($products[$i]['lastStock'] + ($products[$i]['option']['opname'] * -1) + ($products[$i]['option']['transfer'] * -1) - $products[$i]['option']['out'] - $products[$i]['option']['in']));
            $products[$i]['option']['first'] = ($temp > 0) ? $temp : 0;
            $products[$i]['option']['sales'] = 0;
        }
        // dd($products);
        $outlets = Outlet::select('outlet.name')->addSelect('outlet.outlet_id')->get();
        $categories = Category::select('category_id')->addSelect('title')->get();
        $toDate = (!is_null($request->toDate)) ? $toDate : Date('Y-m-d');
        $outletID = ($request->outlet) ? $request->outlet : 0;
        return view('StockCard', compact('title', 'fromDate', 'toDate', 'outlets', 'categories', 'products', 'outletID'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
