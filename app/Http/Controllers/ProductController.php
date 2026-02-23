<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\CategoryController;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $categoryId = $request->category_id;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
    
        $contact = User::where('role_name', '=', 'Admin')->first(); 
    
        $products = Product::with('category')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('product_name', 'like', '%' . $keyword . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($minPrice, function ($query) use ($minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query) use ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->latest()
            ->paginate(10);
        $categories = Category::all();
    
        return view('index', compact('products', 'categories', 'contact'));
    }
    
    
    public function store(Request $request)
    {
        $user = Auth::user();
    
        // Validasi input
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // Handle upload gambar
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('productsAndService', $fileName, 'public');
            $validatedData['picture'] = $filePath;
        }
    
        // Tambahkan user_id dari user yang login
        $validatedData['user_id'] = $user->id;
    
        // Simpan ke database
        Product::create($validatedData);
    
        return redirect()->route('product')->with('success', 'Data berhasil ditambahkan.');
    }
    
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $user = Auth::user();
    
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id', 
        ]);
    
        $product = Product::findOrFail($id);
    
        // Handle upload gambar jika ada file baru
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada
            if ($product->picture && \Storage::disk('public')->exists($product->picture)) {
                \Storage::disk('public')->delete($product->picture);
            }
    
            $file = $request->file('picture');
            $ext = $file->getClientOriginalExtension();
            $fileName = 'product_' . $user->id . '_' . time() . '.' . $ext;
            $filePath = $file->storeAs('productsAndService', $fileName, 'public');
            $validatedData['picture'] = $filePath;
        } else {
            $validatedData['picture'] = $product->picture;
        }
    
        $validatedData['user_id'] = $user->id;
    
        $product->update($validatedData); // ✅ ini juga update category_id karena sudah masuk di $validatedData
    
        return redirect()->route('product')->with('success', 'Data berhasil diubah.');
    }
    
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
    
        // Hapus file gambar jika ada
        if ($product->picture && \Storage::disk('public')->exists($product->picture)) {
            \Storage::disk('public')->delete($product->picture);
        }
    
        // Hapus data dari database
        $product->delete();
    
        return redirect()->route('product')->with('success', 'Data berhasil dihapus.');
    }
    
}
