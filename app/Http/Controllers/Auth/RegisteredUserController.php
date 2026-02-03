<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProductAddCard;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Transfer guest cart items to user after registration
        $this->transferGuestCartToUser($user);

        return redirect(route('index', absolute: false));
    }

    /**
     * Transfer guest cart items to registered user
     */
    private function transferGuestCartToUser($user)
    {
        if (Session::has('cart_session_id')) {
            $sessionId = Session::get('cart_session_id');

            // Get guest cart items
            $guestItems = ProductAddCard::where('session_id', $sessionId)->get();

            foreach ($guestItems as $item) {
                // Check if user already has this product in cart
                $existingItem = ProductAddCard::where('user_id', $user->id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($existingItem) {
                    // Merge quantities
                    $existingItem->quantity += $item->quantity;
                    $existingItem->save();
                    $item->delete();
                } else {
                    // Transfer to user
                    $item->user_id    = $user->id;
                    $item->session_id = null;
                    $item->save();
                }
            }

            // Clear the session cart ID
            Session::forget('cart_session_id');
        }
    }
}
