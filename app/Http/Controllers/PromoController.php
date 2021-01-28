<?php

namespace App\Http\Controllers;

use App\LogHistory;
use App\Outlet;
use App\SpecialPromo;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Promo';
        $specialPromo = SpecialPromo::all();
        $vouchers = Voucher::all();
        return view('promo', compact('title', 'specialPromo', 'vouchers'));
    }
    public function create_special()
    {
        $title = 'Promo';
        $outlets = json_decode(Outlet::select('outlet_id')->addSelect('name')->get(), true);
        return view('promoCreateSpecial', compact('title', 'outlets'));
    }
    public function create_voucher()
    {
        $title = 'Promo';
        $outlets = json_decode(Outlet::select('outlet_id')->addSelect('name')->get(), true);
        return view('promoVoucherCreate', compact('title', 'outlets'));
    }
    public function store_special(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:special_promo,name',
            'discount' => 'required|numeric',
            'isType' => 'required|numeric|min:0|max:1',
            'isActive' => 'required|numeric|min:0|max:1',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $start_date = explode('/', $request->start_date);
        $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'];

        $end_date = explode('/', $request->end_date);
        $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'];

        $promo = new SpecialPromo();
        $promo->name = $request->name;
        $promo->discount = $request->discount;
        $promo->isType = $request->isType;
        $promo->isActive = $request->isActive;
        $promo->start_date = $start_date;
        $promo->end_date = $end_date;
        $promo->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Promo';
        $history->className = 'PromoController';
        $history->functionName = 'store_special';
        $history->description = 'Menambah Spesial Promo id ' . $promo->special_promo_id;
        $history->ip_address = $request->ip();
        $history->save();

        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('promo_outlet')->insert([
                    'special_promo_id' => $promo->special_promo_id,
                    'outlet_id' => $outlet
                ]);
            }
        }

        if($promo->special_promo_id) {
            return redirect('/promo')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Spesial Promo berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Spesial Promo gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function store_voucher(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:special_promo,name',
            'code' => 'required|max:16|min:16|unique:voucher,code',
            'discount' => 'required|numeric',
            'isType' => 'required|numeric|min:0|max:1',
            'isActive' => 'required|numeric|min:0|max:1',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $start_date = explode('/', $request->start_date);
        $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'];

        $end_date = explode('/', $request->end_date);
        $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'];

        $voucher = new Voucher();
        $voucher->name = $request->name;
        $voucher->discount = $request->discount;
        $voucher->code = $request->code;
        $voucher->isType = $request->isType;
        $voucher->description = !empty($request->description) ? $request->description : ' ';
        $voucher->isActive = $request->isActive;
        $voucher->start_date = $start_date;
        $voucher->end_date = $end_date;
        $voucher->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Promo';
        $history->className = 'PromoController';
        $history->functionName = 'store_voucher';
        $history->description = 'Menambah Voucher id ' . $voucher->voucher_id;
        $history->ip_address = $request->ip();
        $history->save();

        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('voucher_outlet')->insert([
                    'voucher_id' => $voucher->voucher_id,
                    'outlet_id' => $outlet
                ]);
            }
        }

        if($voucher->voucher_id) {
            return redirect('/promo')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Voucher berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Voucher gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show_special($id)
    {
        $title = 'Promo';
        $promo = SpecialPromo::where('special_promo_id', $id)->first();
        $outlets = json_decode(Outlet::select('outlet.name')->join('promo_outlet', 'promo_outlet.outlet_id', 'outlet.outlet_id')->where('promo_outlet.special_promo_id', $id)->get(), true);
        $promo['start_date'] = $this->dateTimeId($promo['start_date']);
        $promo['end_date'] = $this->dateTimeId($promo['end_date']);
        return view('promoShowSpecial', compact('title', 'promo', 'outlets'));
    }
    public function show_voucher($id)
    {
        $title = 'Promo';
        $voucher = Voucher::where('voucher_id', $id)->first();
        $outlets = json_decode(Outlet::select('outlet.name')->join('voucher_outlet', 'voucher_outlet.outlet_id', 'outlet.outlet_id')->where('voucher_outlet.voucher_id', $id)->get(), true);
        $voucher['start_date'] = $this->dateTimeId($voucher['start_date']);
        $voucher['end_date'] = $this->dateTimeId($voucher['end_date']);
        return view('promovoucherShow', compact('title', 'voucher', 'outlets'));
    }
    public function edit_special($id)
    {
        $title = 'Promo';
        $promo = SpecialPromo::where('special_promo_id', $id)->first();
        $outletPromo = Outlet::select('outlet.outlet_id')->join('promo_outlet', 'promo_outlet.outlet_id', 'outlet.outlet_id')->where('promo_outlet.special_promo_id', $id)->get();
        $temp = [];
        foreach($outletPromo as $op) {
            $temp[] = $op['outlet_id'];
        }
        $outletPromo = $temp;
        $outlets = Outlet::select('outlet_id')->addSelect('outlet.name')->get();
        $promo['start_date'] = $this->toDateView($promo['start_date']);
        $promo['end_date'] = $this->toDateView($promo['end_date']);
        return view('promoEditSpecial', compact('title', 'promo', 'outlets', 'outletPromo'));
    }
    public function edit_voucher($id)
    {
        $title = 'Promo';
        $voucher = Voucher::where('voucher_id', $id)->first();
        $outletVoucher = Outlet::select('outlet.outlet_id')->join('voucher_outlet', 'voucher_outlet.outlet_id', 'outlet.outlet_id')->where('voucher_outlet.voucher_id', $id)->get();
        $temp = [];
        foreach($outletVoucher as $ov) {
            $temp[] = $ov['outlet_id'];
        }
        $outletVoucher = $temp;
        $outlets = Outlet::select('outlet_id')->addSelect('outlet.name')->get();
        $voucher['start_date'] = $this->toDateView($voucher['start_date']);
        $voucher['end_date'] = $this->toDateView($voucher['end_date']);
        return view('promoVoucherEdit', compact('title', 'voucher', 'outlets', 'outletVoucher'));
    }
    public function update_special(Request $request, $id)
    {
        $checkName = SpecialPromo::select('name')->where('special_promo_id', $id)->first();
        $validate = [
            'discount' => 'required|numeric',
            'isType' => 'required|numeric|min:0|max:1',
            'isActive' => 'required|numeric|min:0|max:1',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $validate['name'] =  ($checkName->name == $request->name) ? 'required' : 'required|unique:special_promo,name';
        $this->validate($request, $validate);

        unset($checkName);
        $start_date = explode('/', $request->start_date);
        $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'];

        $end_date = explode('/', $request->end_date);
        $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'];
        $promo = SpecialPromo::find($id);
        $promo->name = $request->name;
        $promo->discount = $request->discount;
        $promo->isType = $request->isType;
        $promo->isActive = $request->isActive;
        $promo->start_date = $start_date;
        $promo->end_date = $end_date;
        $promo->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Promo';
        $history->className = 'PromoController';
        $history->functionName = 'update_special';
        $history->description = 'Mengubah Spesial Promo id ' . $promo->special_promo_id;
        $history->ip_address = $request->ip();
        $history->save();

        DB::table('promo_outlet')->where('special_promo_id', $id)->delete();
        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('promo_outlet')->insert([
                    'special_promo_id' => $promo->special_promo_id,
                    'outlet_id' => $outlet
                ]);
            }
        }

        if($promo->special_promo_id) {
            return redirect('/promo/special/'. $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Spesial Promo berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/promo/special/'. $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Spesial Promo gagal Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function update_voucher(Request $request, $id)
    {
        $checkName = Voucher::select('name')->addSelect('code')->where('voucher_id', $id)->first();
        $validate = [
            'discount' => 'required|numeric',
            'isType' => 'required|numeric|min:0|max:1',
            'isActive' => 'required|numeric|min:0|max:1',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $validate['name'] =  ($checkName->name == $request->name) ? 'required' : 'required|unique:voucher,name';
        $validate['code'] =  ($checkName->code == $request->code) ? 'required' : 'required|unique:voucher,code';
        $this->validate($request, $validate);

        unset($checkName);
        $start_date = explode('/', $request->start_date);
        $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'];

        $end_date = explode('/', $request->end_date);
        $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'];

        $voucher = Voucher::find($id);
        $voucher->name = $request->name;
        $voucher->code = $request->code;
        $voucher->description = !empty($request->description) ? $request->description : ' ';
        $voucher->discount = $request->discount;
        $voucher->isType = $request->isType;
        $voucher->isActive = $request->isActive;
        $voucher->start_date = $start_date;
        $voucher->end_date = $end_date;
        $voucher->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Promo';
        $history->className = 'PromoController';
        $history->functionName = 'update_voucher';
        $history->description = 'Mengubah Voucher id ' . $voucher->voucher_id;
        $history->ip_address = $request->ip();
        $history->save();

        DB::table('voucher_outlet')->where('voucher_id', $id)->delete();
        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('voucher_outlet')->insert([
                    'voucher_id' => $voucher->voucher_id,
                    'outlet_id' => $outlet
                ]);
            }
        }

        if($voucher->voucher_id) {
            return redirect('/promo/voucher/'. $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Voucher berhasil Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/promo/voucher/'. $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Voucher gagal Diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy_special(Request $request, $id)
    {
        $promo = SpecialPromo::find($id);
        if($promo) {
            DB::table('promo_outlet')->where('special_promo_id', $id)->delete();
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Promo';
            $history->className = 'PromoController';
            $history->functionName = 'destroy_special';
            $history->description = 'Menghapus Spesial Promo id ' . $promo->special_promo_id;
            $history->ip_address = $request->ip();
            $history->save();
            if($promo->delete()) {
                return redirect('/promo')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Spesial Promo berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Spesial Promo gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Spesial Promo Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy_voucher(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        if($voucher) {
            DB::table('voucher_outlet')->where('voucher_id', $id)->delete();
            $history = new LogHistory();
            $history->user_id = Auth::user()->user_id;
            $history->title = 'Promo';
            $history->className = 'PromoController';
            $history->functionName = 'destroy_voucher';
            $history->description = 'Menghapus voucher id ' . $voucher->voucher_id;
            $history->ip_address = $request->ip();
            $history->save();
            if($voucher->delete()) {
                return redirect('/promo')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Voucher berhasil Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Voucher gagal Dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/promo')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> ID Voucher Tidak Ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function dateTimeId($date) {
        $date = explode('-', $date);
        if (count($date) == 3) {
            $date['1'] = (intVal($date['1']) == 1) ? 'Januari' : $date['1'];
            $date['1'] = (intVal($date['1']) == 2) ? 'Februari' : $date['1'];
            $date['1'] = (intVal($date['1']) == 3) ? 'Maret' : $date['1'];
            $date['1'] = (intVal($date['1']) == 4) ? 'April' : $date['1'];
            $date['1'] = (intVal($date['1']) == 5) ? 'Mei' : $date['1'];
            $date['1'] = (intVal($date['1']) == 6) ? 'juni' : $date['1'];
            $date['1'] = (intVal($date['1']) == 7) ? 'Juli' : $date['1'];
            $date['1'] = (intVal($date['1']) == 8) ? 'Agustus' : $date['1'];
            $date['1'] = (intVal($date['1']) == 9) ? 'September' : $date['1'];
            $date['1'] = (intVal($date['1']) == 10) ? 'Oktober' : $date['1'];
            $date['1'] = (intVal($date['1']) == 11) ? 'November' : $date['1'];
            $date['1'] = (intVal($date['1']) == 12) ? 'Desember' : $date['1'];
        }
        return $date['2'] . ' ' . $date['1'] . ' ' . $date['0'];
    }
    public function toDateView($date) {
        $date = explode('-', $date);
        $date = $date['1'] . '/'. $date['2'] . '/'. $date['0'];
        return $date;
    }
    public function codeMaker() {
        $checkDB = true;
        while($checkDB) {
            $randVal = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 1 2 3 4 5 6 7 8 9 0";
            $randVal = explode(' ', $randVal);
            $temp = "CFR";
            for($i=0; $i < 10; $i++) {
                $temp .= $randVal[rand(0, (count($randVal) -1))];
            }
            $temp .= "VCR";
            $checkDB = (is_null(Voucher::select('voucher_id')->where('code', $temp)->first())) ? false : true;
        }
        return response()->json([
            'message' => 'success',
            'code' => $temp,
        ], 200);
    }
}
