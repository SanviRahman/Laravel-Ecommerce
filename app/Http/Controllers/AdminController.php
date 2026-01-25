<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
}
