<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;

class CategoryController extends Controller
{

    
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request,  $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Ambil kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Update data
        $category->update([
            'category_name' => $validatedData['category_name'],
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function showAllCategories(){
        $categories = Category::all();
        return $categories;
    }

    
}
