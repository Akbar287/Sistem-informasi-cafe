<?php

namespace App\Http\Controllers;

use App\Address;
use App\LogHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function profile()
    {
        $title = 'Profil';
        $address = json_decode(Address::select('address.*')->addSelect('employee_address.isDefault')->join('employee_address', 'employee_address.address_id', 'address.address_id')->where('employee_address.user_id', Auth::user()->user_id)->first(), true);
        $log = LogHistory::select('title')->addSelect('className')->addSelect('functionName')->addSelect('ip_address')->addSelect('created_at')->where('user_id', Auth::user()->user_id)->get();
        return view('profile', compact('title', 'address', 'log'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'username' => 'required|min:8|max:12',
            'phone_number' => 'required|numeric',
            'pin' => 'required|numeric',
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

        $password = (!is_null($request->password)) ? Hash::make($request->password) : Auth::user()->password;
        $oldImage = ($request->imageClear == 0) ? Auth::user()->photo : 'nophoto.png';

        if(!is_null($request->file('image'))){
            if (!is_null($oldImage)) {
                if($oldImage != 'nophoto.png'){
                    File::delete(public_path() . '/images/profile/' . $oldImage->image);
                }
            }
            $file = $request->file('image');
            $oldImage = $this->imgRandom($file->getClientOriginalName());
            $file->move(public_path() . '/images/profile/', $oldImage);
        }

        $user = User::find(Auth::user()->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->photo = $oldImage;
        $user->username = $request->username;
        $user->pin = $request->pin;
        $user->phone_number = $request->phone_number;
        $user->password = $password;
        $user->save();

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

        DB::table('employee_address')->insert([
            'address_id' => $address->address_id,
            'user_id' => $user->user_id,
            'isDefault' => 1
        ]);

        $history = new LogHistory();
        $history->user_id = Auth::user()->user_id;
        $history->title = 'Profil';
        $history->className = 'UserController';
        $history->functionName = 'update';
        $history->description = 'Mengubah Data Pribadi';
        $history->ip_address = $request->ip();
        $history->save();

        if($user->user_id) {
            return redirect('/profile')->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil!</strong> Data Profil berhasil diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            return redirect('/profile')->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data Profil gagal diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
