<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $products = Product::latest()->take(9)->get();

        // Get cart count for the current user/session
        $cartCount = $this->getCartCount();

        return view('index', compact('products', 'cartCount'));
    }

    public function viewAllProducts()
    {
        $products = Product::all();
        return view('admin.products.viewallproducts', compact('products'));
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

    public function addToCart($id)
    {
        // Logic to add product to cart
        // This is a placeholder implementation
        $product = Product::findOrFail($id);
        // Here you would typically add the product to the user's cart in the database or session

        return redirect()->back()->with('success', $product->product_name . ' has been added to your cart!');
    }

    /**
     * Get cart count for current user/session
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return ProductAddCard::where('user_id', Auth::id())->count();
        } else {
            if (! Session::has('cart_session_id')) {
                return 0;
            }

            $sessionId = Session::get('cart_session_id');
            return ProductAddCard::where('session_id', $sessionId)->count();
        }
    }

}
