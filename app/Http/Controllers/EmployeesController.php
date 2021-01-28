<?php

namespace App\Http\Controllers;

use App\Address;
use App\LogHistory;
use App\Outlet;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Karyawan';
        $employees = User::select(DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'))->addSelect('role_type.name as role')->addSelect('users.user_id')->join('user_role', 'user_role.user_id', 'users.user_id')->join('role_type', 'role_type.role_type_id', 'user_role.role_type_id')->get();
        $outlet = [];
        foreach($employees as $employee) {
            $outlet[$employee->user_id] = DB::table('user_outlet')->select('outlet.name')->join('outlet', 'outlet.outlet_id', 'user_outlet.outlet_id')->where('user_id', $employee->user_id)->count();
        }
        return view('employees', compact('title', 'employees', 'outlet'));
    }
    public function create()
    {
        $title = 'Karyawan';
        $role = DB::table('role_type')->select('role_type_id')->addSelect('name')->get();
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        return view('employeesCreate', compact('title', 'outlets', 'role'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_verified_at' => 'required',
            'isActive' => 'required',
            'pin' => 'required',
            'password' => 'required|min:8|max:12',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:8|max:12|unique:users,username',
            'phone_number' => 'required|numeric|unique:users,phone_number'
        ]);

        $image = 'nophoto.png';

        if(!is_null($request->file('image'))){
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/profile/', $oldImage);
            $image = $oldImage;
        }

        $employee = new User();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->photo = $image;
        $employee->email = $request->email;
        $employee->username = $request->username;
        $employee->pin = $request->pin;
        $employee->password = Hash::make($request->password);
        $employee->phone_number = $request->phone_number;
        $employee->email_verified_at = ($request->email_verified_at == 1) ? date('y-m-d H:i:s') : null;
        $employee->isActive = ($request->isActive == 1) ? 1 : 0;
        $employee->save();

        DB::table('user_role')->insert([
            'user_id' => $employee->user_id,
            'role_id' => $request->role,
            'role_type_id' => $request->role
        ]);

        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('user_outlet')->insert([
                    'user_id' => $employee->user_id,
                    'outlet_id' => $outlet,
                ]);
            }
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Karyawan';
        $history->className = 'EmployeeController';
        $history->functionName = 'store';
        $history->description = 'Menambah Data Karyawan id ' . $employee->user_id . ' beserta alamat yang bersangkutan';
        $history->ip_address = $request->ip();
        $history->save();

        if($employee->user_id) {
            return redirect('/employees')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Karyawan Berhasil Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/employees')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Karyawan gagal Ditambahkan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function show($id)
    {
        $title = 'Karyawan';
        $employee = User::select('users.*')->addSelect('role_type.name as roleName')->addSelect('role_type.role_type_id as roleId')->join('user_role', 'user_role.user_id', 'users.user_id')->join('role_type', 'role_type.role_type_id', 'user_role.role_type_id')->where('users.user_id', $id)->first();
        $log = LogHistory::select('title')->addSelect('className')->addSelect('functionName')->addSelect('ip_address')->addSelect('created_at')->where('user_id', $id)->get();
        $outletEmployee =  json_decode(DB::table('user_outlet')->select('outlet.outlet_id')->addSelect('outlet.name')->where('user_outlet.user_id', $id)->join('outlet', 'outlet.outlet_id', 'user_outlet.outlet_id')->get(), true);
        $address = json_decode(DB::table('employee_address')->select('address.*')->join('address', 'address.address_id', 'employee_address.address_id')->addSelect('employee_address.isDefault')->where('employee_address.user_id', $id)->get(), true);
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        return view('employeesShow', compact('title', 'employee', 'outletEmployee', 'outlets', 'address', 'log'));
    }
    public function edit($id)
    {
        $title = 'Karyawan';
        $employee = User::select('users.*')->addSelect('role_type.name as roleName')->addSelect('role_type.role_type_id as roleId')->join('user_role', 'user_role.user_id', 'users.user_id')->join('role_type', 'role_type.role_type_id', 'user_role.role_type_id')->where('users.user_id', $id)->first();
        $log = LogHistory::select('title')->addSelect('className')->addSelect('ip_address')->addSelect('created_at')->where('user_id', $id)->get();
        $outletEmployee =  DB::table('user_outlet')->select('outlet.outlet_id')->where('user_outlet.user_id', $id)->join('outlet', 'outlet.outlet_id', 'user_outlet.outlet_id')->get();
        $temp=[];
        foreach($outletEmployee as $outlet) {
            $temp[] = $outlet->outlet_id;
        }
        $outletEmployee = $temp;
        $address = json_decode(DB::table('employee_address')->select('address.*')->join('address', 'address.address_id', 'employee_address.address_id')->get(), true);
        $outlets = Outlet::select('name')->addSelect('outlet_id')->get();
        $role = DB::table('role_type')->select('role_type_id')->addSelect('name')->get();
        return view('employeesEdit', compact('title', 'employee', 'outletEmployee', 'outlets', 'address', 'log', 'role'));
    }
    public function update(Request $request, $id)
    {
        $oldData = User::where('user_id', $id)->first();
        $validate = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_verified_at' => 'required',
            'isActive' => 'required'
        ];
        $validate['email'] = ($oldData->email == $request->email) ? 'required|email' : 'required|email|unique:users,email';
        $validate['username'] = ($oldData->username == $request->username) ? 'required|min:8|max:12' : 'required|min:8|max:12|unique:users,username';
        $validate['phone_number'] = ($oldData->phone_number == $request->phone_number) ? 'required|numeric' : 'required|numeric|unique:users,phone_number';

        $this->validate($request, $validate);

        $employee = User::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->username = $request->username;
        $employee->phone_number = $request->phone_number;
        $employee->email_verified_at = ($request->email_verified_at == 1) ? date('y-m-d H:i:s') : null;
        $employee->isActive = ($request->isActive == 1) ? 1 : 0;
        $employee->save();

        DB::table('user_role')->where('user_id', $id)->delete();
        DB::table('user_role')->insert([
            'user_id' => $id,
            'role_id' => $request->role,
            'role_type_id' => $request->role
        ]);

        DB::table('user_outlet')->where('user_id', $id)->delete();
        if(!empty($request->outlets)) {
            foreach($request->outlets as $outlet) {
                DB::table('user_outlet')->insert([
                'user_id' => $id,
                    'outlet_id' => $outlet,
                ]);
            }
        }

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Karyawan';
        $history->className = 'EmployeeController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Karyawan id ' . $id . ' role, outlet yang bersangkutan';
        $history->ip_address = $request->ip();
        $history->save();

        if($employee->user_id) {
            return redirect('/employee/' . $id)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Karyawan Berhasil diUbah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/employee/' . $id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Karyawan gagal diUbah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }
    public function destroy(Request $request, $id)
    {
        return redirect('/employee/'.$id)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Maaf!</strong> Untuk saat ini data karyawan tidak boleh dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');exit;
        $customer = User::find($id);
        if($customer) {
            if($customer->customer_id) {
                Address::join('employee_address', 'employee_address.address_id', 'address.address_id')->where('employee_address.user_id', $id)->delete();
                DB::table('employee_address')->where('user_id', $id)->delete();

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
