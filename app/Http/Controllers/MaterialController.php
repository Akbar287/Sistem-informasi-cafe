<?php

namespace App\Http\Controllers;

use App\LogHistory;
use App\Material;
use App\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class MaterialController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Bahan Mentah';
        $materials = Material::all();
        return view('materials', compact('materials', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Bahan Mentah';
        $outlets = Outlet::select('outlet_id')->addSelect('name')->get();
        $units = DB::table('unit')->get();
        return view('materialCreate', compact('title', 'outlets', 'units'));
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
            'title' => 'required|unique:materials,title',
            'price' => 'required|numeric',
            'unit' => 'required|numeric',
            'description' => 'required'
        ]);

        $image = 'nophoto.png';

        if(!is_null($request->file('image'))){
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/material/', $oldImage);
            $image = $oldImage;
        }

        $material = new Material();
        $material->title = $request->title;
        $material->price = $request->price;
        $material->unit = $request->unit;
        $material->cover = $image;
        $material->description = $request->description;
        $material->isAlertStock = (!is_null($request->isAlertStock)) ? 1 : 0;
        $material->isManageStock = (!is_null($request->isManageStock)) ? 1 : 0;
        $material->isActive = (!is_null($request->isActive)) ? 1 : 0;
        $material->save();

        DB::table('material_outlet')->where('material_id', $material->material_id)->delete();
        foreach($request->stock as $key => $value) {
            DB::table('material_outlet')->insert([
                'material_id' => $material->material_id,
                'outlet_id' => $key,
                'stock' => $value
            ]);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Bahan Mentah';
        $history->className = 'MaterialController';
        $history->functionName = 'store';
        $history->description = 'Menambah Bahan Mentah dengan id ' . $material->material_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($material->material_id) {
            return redirect('/material')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Bahan Mentah berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/material')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Bahan Mentah gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $title = 'Bahan Mentah';
        $material = Material::select('materials.*')->addSelect('unit.name as unit')->join('unit', 'unit.unit_id', 'materials.unit')->where('material_id', $id)->first();
        $stocks = json_decode(DB::table('material_outlet')->select('stock')->addSelect('material_outlet.material_id')->addSelect('material_outlet.outlet_id')->addSelect('outlet.name')->join('outlet', 'outlet.outlet_id', 'material_outlet.outlet_id')->where('material_id', $id)->get(), true);
        $totalStock = json_decode(DB::table('material_outlet')->select(DB::raw("SUM(material_outlet.stock) as total_stock"))->where('material_id', $id)->get(), true);$totalStock = $totalStock['0']['total_stock'];
        return view('materialShow', compact('material', 'title', 'stocks', 'totalStock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Bahan Mentah';
        $material = Material::where('material_id', $id)->first();
        $stocks = json_decode(DB::table('material_outlet')->select('stock')->addSelect('material_outlet.material_id')->addSelect('material_outlet.outlet_id')->addSelect('outlet.name')->join('outlet', 'outlet.outlet_id', 'material_outlet.outlet_id')->where('material_id', $id)->get(), true);
        $totalStock = json_decode(DB::table('material_outlet')->select(DB::raw("SUM(material_outlet.stock) as total_stock"))->where('material_id', $id)->get(), true);$totalStock = $totalStock['0']['total_stock'];
        $units = DB::table('unit')->get();
        return view('materialEdit', compact('material', 'title', 'stocks', 'totalStock', 'units'));
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
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required|numeric',
            'unit' => 'required|numeric',
            'description' => 'required'
        ]);

        $material = Material::find($id);

        $oldImage = $material->cover;

        if(!is_null($request->file('image'))){
            if (!is_null($oldImage)) {
                if($oldImage != 'nophoto.png'){
                    File::delete(public_path() . '/images/material/' . $oldImage);
                }
            }
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/material/', $oldImage);
        }

        $material->title = $request->title;
        $material->price = $request->price;
        $material->unit = $request->unit;
        $material->cover = $oldImage;
        $material->description = $request->description;
        $material->isAlertStock = (!is_null($request->isAlertStock)) ? 1 : 0;
        $material->isManageStock = (!is_null($request->isManageStock)) ? 1 : 0;
        $material->isActive = (!is_null($request->isActive)) ? 1 : 0;
        $material->save();

        DB::table('material_outlet')->where('material_id', $material->material_id)->delete();
        foreach($request->stock as $key => $value) {
            DB::table('material_outlet')->insert([
                'material_id' => $material->material_id,
                'outlet_id' => $key,
                'stock' => $value
            ]);
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Bahan Mentah';
        $history->className = 'MaterialController';
        $history->functionName = 'store';
        $history->description = 'Mengubah Bahan Mentah dengan id ' . $material->material_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($material->material_id) {
            return redirect('/material/' . $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Bahan Mentah berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/material/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Bahan Mentah gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $material = Material::find($id);
        if($request) {
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Bahan Mentah';
            $history->className = 'MaterialController';
            $history->functionName = 'destroy';
            $history->description = 'Menghapus Bahan Mentah dengan id ' . $material->material_id;
            $history->ip_address = $request->ip();
            $history->save();

            $oldImage = $material->cover;
            if (!is_null($oldImage)) {
                if($oldImage != 'nophoto.png'){
                    File::delete(public_path() . '/images/material/' . $oldImage);
                }
            }

            DB::table('material_outlet')->where('material_id', $id)->delete();
            if($material->delete()) {
                return redirect('/material')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Bahan mentah berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/material')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Bahan mentah gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/material')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Bahan Mentah Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
