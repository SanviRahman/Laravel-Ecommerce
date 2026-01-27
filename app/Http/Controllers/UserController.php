<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->user_type === 'user'){
            return view('dashboard');
        }
        elseif (Auth::check() && Auth::user()->user_type === 'admin') {
            return view('admin.dashboard');
        }
        
    }

    public function home()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }
}
