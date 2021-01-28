<?php

namespace App\Http\Controllers;

use App\LogHistory;
use App\Outlet;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Pajak & Services';
        $taxes = Tax::select('tax_id')->addSelect('tax.name')->addSelect('tax.total')->addSelect('tax_type.name as type')->join('tax_type', 'tax.tax_type_id', 'tax_type.tax_type_id')->get();
        return view('tax', compact('title', 'taxes'));
    }
    public function create()
    {
        $title = 'Pajak & Services';
        $type = DB::table('tax_type')->get();
        $outlet = Outlet::select('name', 'outlet_id')->get();
        return view('taxCreate', compact('title', 'type', 'outlet'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tax,name',
            'type' => 'required|numeric|max:2|min:1',
            'total' => 'required|numeric'
        ]);

        $type = DB::table('tax_type')->select('name')->where('tax_type_id', $request->type)->first();

        $tax = new Tax();
        $tax->tax_type_id = $request->type;
        $tax->name = $request->name;
        $tax->total = $request->total;
        $tax->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Pajak & Services';
        $history->className = 'TaxController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Pajak & Services id ' . $tax->tax_id;
        $history->ip_address = $request->ip();
        $history->save();

        if(!is_null($request->outlet) && !empty($request->outlet)) {
            foreach($request->outlet as $outlet) {
                DB::table('outlet_tax')->insert([
                    'outlet_id' => $outlet,
                    'tax_id' => $tax->tax_id
                ]);
            }
        }

        if($tax->tax_id) {
            return redirect('/tax')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data '. $type->name .' Berhasil ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/tax')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data '. $type->name .' gagal ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Pajak & Services';
        $taxes = Tax::select('tax_id')->addSelect('tax.name')->addSelect('tax.total')->addSelect('tax.created_at')->addSelect('tax_type.name as type')->join('tax_type', 'tax.tax_type_id', 'tax_type.tax_type_id')->where('tax_id', $id)->first();
        $outlet = json_decode(Outlet::select('outlet.outlet_id')->addSelect('outlet.name')->join('outlet_tax', 'outlet_tax.outlet_id', 'outlet.outlet_id')->where('outlet_tax.tax_id', $id)->get(), true);
        return view('taxShow', compact('title', 'taxes', 'outlet'));
    }
    public function edit($id)
    {
        $title = 'Pajak & Services';
        $taxes = Tax::select('tax_id')->addSelect('tax.name')->addSelect('tax.total')->addSelect('tax.created_at')->addSelect('tax_type_id')->where('tax_id', $id)->first();
        $type = DB::table('tax_type')->get();
        $outlets = json_decode(DB::table('outlet_tax')->select('outlet_id')->where('tax_id', $id)->get(), true);
        $outletTax = [];
        foreach($outlets as $outlet) {
            $temp[] = $outlet['outlet_id'];
        }
        $outletTax = $temp;
        $outlet = Outlet::select('outlet_id')->addSelect('name')->get();
        return view('taxEdit', compact('title', 'taxes', 'type', 'outletTax', 'outlet'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required|numeric|max:2|min:1',
            'total' => 'required|numeric'
        ]);

        $type = DB::table('tax_type')->select('name')->where('tax_type_id', $request->type)->first();

        $tax = Tax::find($id);
        $tax->tax_type_id = $request->type;
        $tax->name = $request->name;
        $tax->total = $request->total;
        $tax->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Pajak & Services';
        $history->className = 'TaxController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Pajak & Services id ' . $tax->tax_id;
        $history->ip_address = $request->ip();
        $history->save();

        DB::table('outlet_tax')->where('tax_id', $id)->delete();
        if(!is_null($request->outlet) && !empty($request->outlet)) {
            foreach($request->outlet as $outlet) {
                DB::table('outlet_tax')->insert([
                    'outlet_id' => $outlet,
                    'tax_id' => $tax->tax_id
                ]);
            }
        }

        if($tax->tax_id) {
            return redirect('/tax/'. $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data '. $type->name .' Berhasil diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/tax/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data '. $type->name .' gagal diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        $taxes = Tax::find($id);
        if($taxes) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Pajak & Services';
            $history->className = 'TaxController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Data Pajak & Services id ' . $taxes->tax_id;
            $history->ip_address = $request->ip();
            $history->save();

            if($taxes->delete()) {
                return redirect('/tax')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Pajak / Services Berhasil dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/tax')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Pajak / Services gagal dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        }
    }
}
