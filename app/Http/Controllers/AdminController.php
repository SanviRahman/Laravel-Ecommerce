<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'slug' => \Str::slug($request->name),
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
            'slug' => \Str::slug($request->name),
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
    public function productIndex()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Product Create View
    public function productCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Product Store
    public function productStore(Request $request)
    {
        $request->validate([
            'product_title'       => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity'    => 'required|integer|min:0',
            'product_price'       => 'required|numeric|min:0',
            'product_category'    => 'required|exists:categories,id',
            'product_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            // Public folder e upload
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
        ]);

        $imagePath = $product->product_image;
        if ($request->hasFile('product_image')) {
            // Create directory if not exists
            $directory = public_path('uploads/products');
            if (! file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();

            // Move file to public directory
            $request->file('product_image')->move($directory, $filename);

            // Store path in database
            $imagePath = 'uploads/products/' . $filename;

            // Delete old image if exists (optional)
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
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    // Product Delete
    public function productDelete($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
