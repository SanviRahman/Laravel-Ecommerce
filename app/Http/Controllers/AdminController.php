<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ConfirmOrder;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //                                         <========= Category Methods =======>
    // Category Index - Show all categories
    public function categoryIndex()
    {
        $categories = Category::paginate(10);
        return view('admin.index', compact('categories'));
    }

    // Add Category Form
    public function addCategory()
    {
        return view('admin.create');
    }

    // Store Category
    public function storeCategory(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        // Create category
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category added successfully!');
    }

    // Edit Category Form
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit', compact('category'));
    }

    // Update Category
    public function updateCategory(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);

        // Update category
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    // Delete Category
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    //                                             <========= Product Methods =======>

    // Product Index
    public function productIndex(Request $request)
    {
        $search     = $request->input('search');
        $searchType = $request->input('search_type', 'product_title');

        $query = Product::with('category');

        if ($search) {
            if ($searchType == 'product_category') {
                // Search by category name through relationship
                $query->whereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            } else {
                // Search by product fields
                $query->where($searchType, 'like', '%' . $search . '%');
            }
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products', 'search', 'searchType'));
    }

    // Product Create View
    public function productCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Product Store
    // In AdminController.php - productStore method
    public function productStore(Request $request)
    {
        $request->validate([
            'product_title'       => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity'    => 'required|integer|min:0',
            'product_price'       => 'required|numeric|min:0',
            'product_category'    => 'required|exists:categories,id',
            'product_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // New validations for clothes category
            'available_sizes'     => 'nullable|array',
            'available_sizes.*'   => 'in:S,M,L,XL,XXL',
            'measurement_details' => 'nullable|string|max:1000',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imageName = time() . '_' . $request->file('product_image')->getClientOriginalName();
            $request->file('product_image')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'product_title'       => $request->product_title,
            'product_description' => $request->product_description,
            'product_quantity'    => $request->product_quantity,
            'product_price'       => $request->product_price,
            'product_category'    => $request->product_category,
            'product_image'       => $imagePath,
            // New fields
            'available_sizes'     => $request->available_sizes,
            'measurement_details' => $request->measurement_details,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    // Product Edit View
    public function productEdit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Product Update
    // In AdminController.php - productUpdate method
    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_title'       => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity'    => 'required|integer|min:0',
            'product_price'       => 'required|numeric|min:0',
            'product_category'    => 'required|exists:categories,id',
            'product_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // New validations for clothes category
            'available_sizes'     => 'nullable|array',
            'available_sizes.*'   => 'in:S,M,L,XL,XXL',
            'measurement_details' => 'nullable|string|max:1000',
        ]);

        $imagePath = $product->product_image;
        if ($request->hasFile('product_image')) {
            $directory = public_path('uploads/products');
            if (! file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();
            $request->file('product_image')->move($directory, $filename);
            $imagePath = 'uploads/products/' . $filename;

            if ($product->product_image && file_exists(public_path($product->product_image))) {
                unlink(public_path($product->product_image));
            }
        }

        $product->update([
            'product_title'       => $request->product_title,
            'product_description' => $request->product_description,
            'product_quantity'    => $request->product_quantity,
            'product_price'       => $request->product_price,
            'product_category'    => $request->product_category,
            'product_image'       => $imagePath,
            // New fields
            'available_sizes'     => $request->available_sizes,
            'measurement_details' => $request->measurement_details,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    // Product Delete
    public function productDelete($id)
    {
        $product = Product::findOrFail($id);

        try {
            // Delete image from public/uploads folder if exists
            if ($product->product_image) {
                $imagePath = public_path($product->product_image);

                // Check if file exists in public path
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());

            return redirect()->route('products.index')
                ->with('error', 'Error deleting product. Please try again.');
        }
    }

    // Product Search (Alternative method if you want separate search)
    public function productSearch(Request $request)
    {
        $search     = $request->input('search');
        $searchType = $request->input('search_type', 'product_title');

        $query = Product::with('category');

        if ($search) {
            if ($searchType == 'product_category') {
                // Search by category name through relationship
                $query->whereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            } else {
                // Search by product fields
                $query->where($searchType, 'like', '%' . $search . '%');
            }
        }

        $products = $query->latest()->paginate(10);

        return view('admin.products.index', compact('products', 'search', 'searchType'));
    }

    //                                              <========= Order Methods =======>

    public function viewOrders(Request $request)
    {
        $query = ConfirmOrder::with('items')->latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by customer type
        if ($request->has('customer_type') && $request->customer_type) {
            $query->where('customer_type', $request->customer_type);
        }

        $orders = $query->paginate(20);

        // Calculate statistics
        $stats = [
            'total_orders'   => ConfirmOrder::count(),
            'total_revenue'  => ConfirmOrder::sum('total'),
            'pending_orders' => ConfirmOrder::where('status', 'pending')->count(),
            'guest_orders'   => ConfirmOrder::where('customer_type', 'guest')->count(),
        ];

        return view('admin.orders.vieworders', compact('orders', 'stats'));
    }

    /**
     * Show update status form
     */
    public function showUpdateStatusForm($id)
    {
        $order = ConfirmOrder::with('items')->findOrFail($id);
        return view('admin.orders.update-status', compact('order'));
    }

    /**
     * Update order status (POST request)
     */
    /**
     * Update order status (POST request)
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = ConfirmOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'admin_notes'    => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare notes
        $notes = $order->notes;
        if ($request->admin_notes) {
            $timestamp = now()->format('d M Y h:i A');
            $adminNote = "\n[Admin - {$timestamp}]: {$request->admin_notes}";
            $notes     = $order->notes ? $order->notes . $adminNote : $adminNote;
        }

        $order->update([
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
            'notes'          => $notes,
        ]);

        Log::info('Order status updated by admin', [
            'order_id'           => $order->id,
            'order_number'       => $order->order_number,
            'admin_id'           => Auth::id(),
            'new_status'         => $request->status,
            'new_payment_status' => $request->payment_status,
        ]);

        return redirect()->route('orders.view')
            ->with('success', "Order #{$order->order_number} status updated successfully!");
    }
    /**
     * Edit order view
     */
    public function editOrder($id)
    {
        $order = ConfirmOrder::with('items.product')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update order
     */
    public function updateOrder(Request $request, $id)
    {
        $order = ConfirmOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order->update([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'notes'          => $request->notes,
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('orders.view')
            ->with('success', 'Order updated successfully!');
    }

    //Download order invoice (PDF)
    public function downloadInvoice($order_number)
    {
        try {
            // Find the order
            $order = ConfirmOrder::where('order_number', $order_number)->with('items')->first();

            if (! $order) {
                return redirect()->route('guest.track.order')->with('error', 'Order not found!');
            }

            // Generate PDF invoice
            $pdf = Pdf::loadView('admin.invoices.guest_invoice', compact('order'));

            // Download the PDF
            return $pdf->download('invoice-' . $order->order_number . '.pdf');

        } catch (\Exception $e) {
            return redirect()->route('guest.track.order')->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }
}
