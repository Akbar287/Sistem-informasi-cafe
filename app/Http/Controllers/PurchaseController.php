<?php

namespace App\Http\Controllers;

use App\FOB_PO;
use App\Outlet;
use App\Supplier;
use App\Term_PO;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Purchase Order';
        $purchases = [];
        return view('purchaseOrder', compact('title', 'purchases'));
    }
    //Daftar Belanja
    public function list()
    {
        $title = 'Daftar Belanja';
        return view('purchaseList', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Purchase Order';
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        $suppliers = Supplier::select('supplier_id')->addSelect('company')->get();
        $fobs = FOB_PO::select('name')->addSelect('fob_id')->get();
        $terms = Term_PO::select('term_id')->addSelect('term')->get();
        return view('purchaseOrderCreate', compact('title', 'outlets', 'suppliers', 'fobs', 'terms'));
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
