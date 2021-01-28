<?php

namespace App\Http\Controllers;

use App\LogHistory;
use App\MapsOutlet;
use App\Material;
use App\Outlet;
use App\ProductVariation;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Outlet';
        $outlets = Outlet::select('outlet.name')->addSelect('outlet.telephone as phone_number')->addSelect('outlet.city')->addSelect('outlet.outlet_id')->get();
        $tax = [];
        foreach ($outlets as $outlet) {
            $tax[$outlet->outlet_id] = !is_null(DB::table('outlet_tax')->where('outlet_id', $outlet->outlet_id)->first()) ? 1 : 0;
        }
        return view('outlet', compact('title', 'outlets', 'tax'));
    }
    public function create()
    {
        $title = 'Outlet';
        $taxes = Tax::select('tax.*')->addSelect('tax_type.name as taxType')->join('tax_type', 'tax_type.tax_type_id', 'tax.tax_type_id')->get();
        return view('outletCreate', compact('title', 'taxes'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:outlet,name',
            'address' => 'required',
            'city' => 'required',
            'phone_number' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        $isTable = (!is_null($request->isTable)) ? 1 : 0;
        $isActive = (!is_null($request->isActive)) ? 1 : 0;

        $outlet = new Outlet();
        $outlet->name = $request->name;
        $outlet->address = $request->address;
        $outlet->city = $request->city;
        $outlet->telephone = $request->phone_number;
        $outlet->isTable = $isTable;
        $outlet->isActive = $isActive;
        $outlet->save();

        $maps = new MapsOutlet();
        $maps->outlet_id = $outlet->outlet_id;
        $maps->lat = $request->lat;
        $maps->lng = $request->lng;
        $maps->save();

        if (!is_null($request->taxOutlet) || !empty($request->taxOutlet)) {
            foreach($request->taxOutlet as $tax) {
                DB::table('outlet_tax')->insert([
                    'outlet_id' => $outlet->outlet_id,
                    'tax_id' => $tax
                ]);
            }
        }

        $material = Material::select('material_id')->get();
        foreach($material as $materi) {
            DB::table('material_outlet')->insert([
                'material_id' => $materi->material_id,
                'outlet_id' => $outlet->outlet_id,
                'stock' => 0
            ]);
        }

        $productVariations = ProductVariation::select('product_variation_id')->get();
        foreach($productVariations as $productVariation) {
            DB::table('stock_outlet')->insert([
                'product_variation_id' => $productVariation->product_variation_id,
                'outlet_id' => $outlet->outlet_id,
                'stock' => 0,
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            ]);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Outlet';
        $history->className = 'OutletController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Outlet id ' . $outlet->outlet_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($outlet->outlet_id) {
            return redirect('/outlet')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Outlet Berhasil ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/outlet')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Outlet gagal ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Outlet';
        $outlet = Outlet::select('outlet.*')->where('outlet_id', $id)->first();
        $tax = json_decode(Tax::select('tax.tax_id')->addSelect('tax.name')->addSelect('tax_type.name as typeName')->join('outlet_tax', 'outlet_tax.tax_id', 'tax.tax_id')->join('tax_type', 'tax_type.tax_type_id', 'tax.tax_type_id')->where('outlet_tax.outlet_id', $id)->get(), true);
        return view('outletShow', compact('title', 'outlet', 'tax'));
    }
    public function edit($id)
    {
        $title = 'Outlet';
        $outlet = Outlet::select('outlet.*')->addSelect('maps_outlet.lat')->addSelect('maps_outlet.lng')->join('maps_outlet', 'maps_outlet.outlet_id', 'outlet.outlet_id')->where('outlet.outlet_id', $id)->first();
        $taxOutlet = Outlet::select('tax.tax_id')->join('outlet_tax', 'outlet_tax.outlet_id', 'outlet.outlet_id')->join('tax', 'outlet_tax.tax_id', 'tax.tax_id')->where('outlet.outlet_id', $id)->get();
        $taxes = Tax::select('tax.*')->addSelect('tax_type.name as taxType')->join('tax_type', 'tax_type.tax_type_id', 'tax.tax_type_id')->get();
        $temp = [];
        foreach($taxOutlet as $tax) {
            $temp[] = $tax->tax_id;
        }
        $taxOutlet = $temp;
        unset($temp);
        return view('outletEdit', compact('title', 'outlet', 'taxes', 'taxOutlet'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone_number' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        $isTable = (!is_null($request->isTable)) ? 1 : 0;
        $isActive = (!is_null($request->isActive)) ? 1 : 0;

        $outlet = Outlet::find($id);
        $outlet->name = $request->name;
        $outlet->address = $request->address;
        $outlet->city = $request->city;
        $outlet->telephone = $request->phone_number;
        $outlet->isTable = $isTable;
        $outlet->isActive = $isActive;
        $outlet->save();

        $maps_id = MapsOutlet::select('maps_outlet_id')->where('outlet_id', $id)->first();

        $maps = MapsOutlet::find($maps_id->maps_outlet_id);
        $maps->outlet_id = $outlet->outlet_id;
        $maps->lat = $request->lat;
        $maps->lng = $request->lng;
        $maps->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Outlet';
        $history->className = 'OutletController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Outlet id ' . $outlet->outlet_id;
        $history->ip_address = $request->ip();
        $history->save();

        DB::table('outlet_tax')->where('outlet_id', $id)->delete();
        if (!is_null($request->taxOutlet) || !empty($request->taxOutlet)) {
            foreach($request->taxOutlet as $tax) {
                DB::table('outlet_tax')->insert([
                    'outlet_id' => $outlet->outlet_id,
                    'tax_id' => $tax
                ]);
            }
        }

        if($outlet->outlet_id) {
            return redirect('/outlet/' . $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Outlet Berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/outlet/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Outlet gagal Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        $outlet = Outlet::find($id);
        if($outlet) {
            DB::table('outlet_tax')->where('outlet_id', $id)->delete();
            DB::table('material_outlet')->where('outlet_id', $id)->delete();
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Outlet';
            $history->className = 'OutletController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Data Outlet id ' . $outlet->outlet_id;
            $history->ip_address = $request->ip();
            $history->save();

            if($outlet->delete()) {
                return redirect('/outlet')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Outlet Berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/outlet')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Outlet gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/outlet')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Outlet Tidak Ditemukan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function maps()
    {
        $maps = json_decode(Outlet::select('outlet.outlet_id as id')->addSelect('outlet.name')->addSelect('outlet.address')->addSelect('maps_outlet.lat')->addSelect('maps_outlet.lng')->join('maps_outlet', 'maps_outlet.outlet_id', 'outlet.outlet_id')->get(), true);

        return response()->json([
            'status' => 200,
            'message' => 'Success to get outlet Cordinate',
            'data' => $maps
        ], 200);
    }
}
