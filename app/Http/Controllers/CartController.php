<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAddCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Get cart items
    public function index()
    {
        if (auth()->check()) {
            $cartItems = ProductAddCard::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            // Generate session ID for guest if not exists
            if (! Session::has('cart_session_id')) {
                Session::put('cart_session_id', 'guest_' . uniqid());
            }

            $sessionId = Session::get('cart_session_id');
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        return view('cart.index', compact('cartItems'));
    }

    // Add to cart - FIXED VERSION
    public function addToCart(Request $request, $productId)
    {
        // Find the product
        $product  = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        // Check if user is logged in
        if (auth()->check()) {
            $userId    = auth()->id();
            $sessionId = null;
        } else {
            // Generate unique session ID for guest
            if (! Session::has('cart_session_id')) {
                Session::put('cart_session_id', 'guest_' . uniqid() . '_' . time());
            }
            $sessionId = Session::get('cart_session_id');
            $userId    = null;
        }

        // Check if product already in cart
        if ($userId) {
            // For logged in users
            $cartItem = ProductAddCard::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();
        } else {
            // For guests
            $cartItem = ProductAddCard::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();
        }

        if ($cartItem) {
            // Update quantity if exists
            $cartItem->quantity += $quantity;
            $cartItem->save();
            $message  = 'Product quantity updated in cart!';
        } else {
            // Create new cart item
            ProductAddCard::create([
                'session_id'    => $sessionId,
                'user_id'       => $userId,
                'product_id'    => $productId,
                'quantity'      => $quantity,
                'price'         => $product->product_price,
                'product_title' => $product->product_title,
            ]);
            $message = 'Product added to cart successfully!';
        }

        // Get updated cart count
        $cartCount = $this->getCartCount();

        return response()->json([
            'success'    => true,
            'message'    => $message,
            'cart_count' => $cartCount,
        ]);
    }

    // Remove from cart
    public function removeFromCart($id)
    {
        if (auth()->check()) {
            $cartItem = ProductAddCard::where('user_id', auth()->id())
                ->where('id', $id)
                ->first();
        } else {
            if (! Session::has('cart_session_id')) {
                return response()->json(['success' => false]);
            }

            $sessionId = Session::get('cart_session_id');
            $cartItem  = ProductAddCard::where('session_id', $sessionId)
                ->where('id', $id)
                ->first();
        }

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Product removed from cart',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    // Update cart quantity
    public function updateCart(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            $cartItem = ProductAddCard::where('user_id', auth()->id())
                ->where('id', $id)
                ->first();
        } else {
            if (! Session::has('cart_session_id')) {
                return response()->json(['success' => false]);
            }

            $sessionId = Session::get('cart_session_id');
            $cartItem  = ProductAddCard::where('session_id', $sessionId)
                ->where('id', $id)
                ->first();
        }

        if ($cartItem) {
            if ($quantity > 0) {
                $cartItem->quantity = $quantity;
                $cartItem->save();

                // Calculate new total
                $newTotal = $cartItem->price * $quantity;

                return response()->json([
                    'success'    => true,
                    'message'    => 'Cart updated successfully',
                    'cart_count' => $this->getCartCount(),
                    'new_total'  => number_format($newTotal, 2),
                ]);
            } else {
                $cartItem->delete();
            }
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Cart updated successfully',
            'cart_count' => $this->getCartCount(),
        ]);
    }

    // Get cart count
    public function getCartCount()
    {
        if (auth()->check()) {
            return ProductAddCard::where('user_id', auth()->id())->count();
        } else {
            if (! Session::has('cart_session_id')) {
                return 0;
            }

            $sessionId = Session::get('cart_session_id');
            return ProductAddCard::where('session_id', $sessionId)->count();
        }
    }

    // API to get cart count
    public function getCartCountApi()
    {
        return response()->json([
            'count' => $this->getCartCount(),
        ]);
    }

    // Get cart data
    public function getCartData()
    {
        if (auth()->check()) {
            $cartItems = ProductAddCard::where('user_id', auth()->id())
                ->with('product')
                ->get();
        } else {
            if (! Session::has('cart_session_id')) {
                return response()->json(['items' => [], 'total' => 0, 'count' => 0]);
            }

            $sessionId = Session::get('cart_session_id');
            $cartItems = ProductAddCard::where('session_id', $sessionId)
                ->with('product')
                ->get();
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->price * $item->quantity;
        }

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
            'count' => $cartItems->count(),
        ]);
    }
}
