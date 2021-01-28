<?php

namespace App\Http\Controllers;

use App\Address;
use App\CustomerAddress;
use App\Customers;
use App\LogHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Pelanggan';
        $customers = Customers::select(DB::raw('CONCAT(first_name, " ", last_name) as name'))->addSelect('phone_number')->addSelect('email')->addSelect('customer_id')->get();
        return view('customer', compact('title', 'customers'));
    }
    public function create()
    {
        $title = 'Pelanggan';
        return view('customerCreate', compact('title'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'username' => 'required|min:8|max:12|unique:customers,username',
            'phone_number' => 'required|numeric|unique:customers,phone_number',
            'pin' => 'required|numeric',
            'password' => 'required',
            "country" => 'required',
            "province" => 'required',
            "city" => 'required',
            "district" => 'required',
            "subDistrict" => 'required',
            "rw" => 'required|numeric',
            "rt" => 'required|numeric',
            "number_house" => 'required',
            "postal_code" => 'required|numeric',
        ]);

        $image = 'nophoto.png';

        if(!is_null($request->file('image'))){
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/customers/', $oldImage);
            $image = $oldImage;
        }

        $customer = new Customers();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->photo = $image;
        $customer->username = $request->username;
        $customer->pin = $request->pin;
        $customer->password = Hash::make($request->password);
        $customer->isActive = (!is_null($request->isActive)) ? 1 : 0;
        $customer->save();

        $address = new Address();
        $address->country = $request->country;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->District = $request->district;
        $address->subDistrict = $request->subDistrict;
        $address->rw = $request->rw;
        $address->rt = $request->rt;
        $address->number_house = $request->number_house;
        $address->postal_code = $request->postal_code;
        $address->save();

        $relation = new CustomerAddress();
        $relation->address_id = $address->address_id;
        $relation->customer_id = $customer->customer_id;
        $relation->isDefault = 1;
        $relation->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Pelanggan';
        $history->className = 'CustomerController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Pelanggan id ' . $customer->customer_id . ' beserta alamat yang bersangkutan';
        $history->ip_address = $request->ip();
        $history->save();

        if($relation->id) {
            return redirect('/customer')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Pelanggan berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/customer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Pelanggan gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Pelanggan';
        $customer = Customers::select('customers.*')->where('customer_id', $id)->first();
        $address = json_decode(Address::select('address.*')->addSelect('customer_address.isDefault')->join('customer_address', 'customer_address.address_id', 'address.address_id')->where('customer_address.customer_id', $id)->get(), true);
        return view('customerShow', compact('title', 'customer', 'address'));
    }
    public function edit($id)
    {
        $title = 'Pelanggan';
        $customer = Customers::select('customers.*')->where('customer_id', $id)->first();
        $address = json_decode(Address::select('address.*')->addSelect('customer_address.isDefault')->join('customer_address', 'customer_address.address_id', 'address.address_id')->where('customer_address.customer_id', $id)->get(), true);
        return view('customerEdit', compact('title', 'customer', 'address'));
    }
    public function update(Request $request, $id)
    {
        $oldData = Customers::where('customer_id', $id)->first();
        $validate = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_verified_at' => 'required',
            'isActive' => 'required'
        ];
        $validate['email'] = ($oldData->email == $request->email) ? 'required|email' : 'required|email|unique:customers,email';
        $validate['username'] = ($oldData->username == $request->username) ? 'required|min:8|max:12' : 'required|min:8|max:12|unique:customers,username';
        $validate['phone_number'] = ($oldData->phone_number == $request->phone_number) ? 'required|numeric' : 'required|numeric|unique:customers,phone_number';

        $this->validate($request, $validate);

        $customer = Customers::find($id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->username = $request->username;
        $customer->phone_number = $request->phone_number;
        $customer->email_verified_at = ($request->email_verified_at == 1) ? date('y-m-d H:i:s') : null;
        $customer->isActive = ($request->isActive == 1) ? 1 : 0;
        $customer->save();

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Pelanggan';
        $history->className = 'CustomerController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Pelanggan id ' . $customer->customer_id;
        $history->ip_address = $request->ip();
        $history->save();

        if($customer->customer_id) {
            return redirect('/customer/' . $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Pelanggan Berhasil Diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/customer/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Pelanggan gagal Diubah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        return redirect('/customer/'.$id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Maaf!</strong> Untuk saat ini data pelanggan tidak boleh dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
        $customer = Customers::find($id);
        if($customer) {
            if($customer->customer_id) {
                Address::join('customer_address', 'customer_address.address_id', 'address.address_id')->where('customer_address.customer_id', $id)->delete();
                CustomerAddress::where('customer_id', $id)->delete();

                $history = new LogHistory();
                $history->user_id = Auth::user()->user_id;
                $history->title = 'Pelanggan';
                $history->className = 'CustomerController';
                $history->functionName = 'destroy';
                $history->description = 'Menghapus Data Pelanggan id ' . $customer->customer_id . ' nama ' . $customer->first_name . ' ' . $customer->last_name .' dan email ' . $customer->email;
                $history->ip_address = $request->ip();
                $history->save();

                $customer->delete();
                return redirect('/customer')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Pelanggan, Alamat dan Transaksi berkaitan dengan Pelanggan Berhasil diHapus!.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                return redirect('/customer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Pelanggan, Alamat dan Transaksi berkaitan dengan Pelanggan gagal ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        } else {
            return redirect('/customer')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Pelanggan tidak Ditemukan!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
