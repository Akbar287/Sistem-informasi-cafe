<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Outlet;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $title = 'Home';
        $widget = ['customers' => Customers::count(), 'transactions' => 0, 'outlets' => Outlet::count(), 'products' => Products::count() ];
        return view('home', compact('title', 'widget'));
    }
}
