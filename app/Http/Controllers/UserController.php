<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConfirmOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Http\Request;
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
        $products = Product::latest()->take(10)->get();

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
     * User Dashboard
     */
    public function dashboard()
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Get user's orders with pagination
        $orders = ConfirmOrder::where('user_id', $user->id)
            ->orWhere('email', $user->email) // Also get orders by email for guest orders that became registered
            ->with('items')
            ->latest()
            ->paginate(10);
        
        // Get cart count for the user
        $cartCount = $this->getCartCount();
        
        // Statistics for user
        $stats = [
            'total_orders' => ConfirmOrder::where('user_id', $user->id)->count(),
            'pending_orders' => ConfirmOrder::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'delivered_orders' => ConfirmOrder::where('user_id', $user->id)
                ->where('status', 'delivered')
                ->count(),
            'total_spent' => ConfirmOrder::where('user_id', $user->id)->sum('total'),
        ];
        
        return view('dashboard', compact('user', 'orders', 'cartCount', 'stats'));
    }
    
    
    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        
        // Update all orders with new email if email changed
        if ($request->email != $user->getOriginal('email')) {
            ConfirmOrder::where('email', $user->getOriginal('email'))
                ->update(['email' => $request->email]);
        }
        
        return redirect()->route('dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Get cart count for current user/session
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return ProductAddCard::where('user_id', Auth::id())->sum('quantity');
        } else {
            if (! Session::has('cart_session_id')) {
                return 0;
            }

            $sessionId = Session::get('cart_session_id');
            return ProductAddCard::where('session_id', $sessionId)->sum('quantity');
        }
    }
}