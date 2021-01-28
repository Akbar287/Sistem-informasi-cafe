<?php

namespace App\Http\Controllers;

use App\LogHistory;
use App\Supplier;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Supplier';
        $supplier = Supplier::all();
        return view('supplier', compact('title', 'supplier'));
    }
    public function create()
    {
        $title = 'Supplier';
        $taxes = Tax::all();
        return view('supplierCreate', compact('title', 'taxes'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'company' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:supplier,email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ]);

        $supplier = new Supplier();
        $supplier->company = $request->company;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone_number = $request->phone_number;
        $supplier->address = $request->address;
        $supplier->save();

        if(!is_null($request->taxSupplier)) {
            $data = [];
            foreach($request->taxSupplier as $tax) {
                $data[] = ['supplier_id' => $supplier->supplier_id, 'tax_id' => $tax];
            }
            DB::table('supplier_tax')->insert($data);unset($data);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Supplier';
        $history->className = 'SupplierController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Supplier id ' . $supplier->supplier_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($supplier->supplier_id) {
            return redirect('/supplier')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Supplier Berhasil ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/supplier')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Supplier gagal ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Supplier';
        $supplier = Supplier::find($id);
        $tax = json_decode(Tax::select('tax.tax_id')->addSelect('tax.name')->addSelect('tax_type.name as typeName')->join('supplier_tax', 'supplier_tax.tax_id', 'tax.tax_id')->join('tax_type', 'tax_type.tax_type_id', 'tax.tax_type_id')->where('supplier_tax.supplier_id', $id)->get(), true);
        return view('supplierShow', compact('title', 'supplier', 'tax'));
    }
    public function edit($id)
    {
        $title = 'Supplier';
        $taxes = Tax::all();
        $taxSupplier = DB::table('supplier_tax')->select('tax_id')->where('supplier_id', $id)->get();
        $temp = [];
        foreach($taxSupplier as $tax) {
            $temp[] = $tax->tax_id;
        }
        $taxSupplier = $temp;
        $supplier = Supplier::find($id);
        return view('supplierEdit', compact('title', 'supplier', 'taxes', 'taxSupplier'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ]);

        $supplier = Supplier::find($id);
        $supplier->company = $request->company;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone_number = $request->phone_number;
        $supplier->address = $request->address;
        $supplier->save();

        if(!is_null($request->taxSupplier)) {
            DB::table('supplier_tax')->where('supplier_id', $id)->delete();
            $data = [];
            foreach($request->taxSupplier as $tax) {
                $data[] = ['supplier_id' => $id, 'tax_id' => $tax];
            }
            DB::table('supplier_tax')->insert($data);unset($data);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Supplier';
        $history->className = 'SupplierController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Supplier id ' . $supplier->supplier_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($supplier->supplier_id) {
            return redirect('/supplier/'.$id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Supplier Berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/supplier/'.$id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Supplier gagal Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if($supplier) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Supplier';
            $history->className = 'SupplierController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Data Supplier id ' . $supplier->supplier_id;
            $history->ip_address = $request->ip();
            $history->save();

            if($supplier->delete()) {
                return redirect('/supplier')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Supplier Berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/supplier')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Supplier gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/supplier')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Supplier Tidak Ditemukan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
}
