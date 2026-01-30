<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->user_type === 'user') {
            return view('dashboard');
        } elseif (Auth::check() && Auth::user()->user_type === 'admin') {
            return view('admin.dashboard');
        }

    }

    public function home()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);

        // Get related products (same category)
        $relatedProducts = Product::where('product_category', $product->product_category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('admin.products.product_details', compact('product', 'relatedProducts'));
    }
}
