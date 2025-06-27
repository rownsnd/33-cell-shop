<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
     public function index(Request $request)
     {
         $title = 'Product';
         $keyword = $request->keyword;
         $categoryId = $request->category_id;
     
         $products = Product::with('category')
             ->when($keyword, function ($query) use ($keyword) {
                 $query->where('product_name', 'like', '%' . $keyword . '%');
             })
             ->when($categoryId, function ($query) use ($categoryId) {
                 $query->where('category_id', $categoryId);
             })
             ->latest()
             ->get();
     
         $categories = \App\Models\Category::all();
     
         return view('admin.product', compact('products', 'categories', 'title'));
     }
     
     

    /**
     * Show the form for creating a new resource.
     */
    public function dashboard()
    {
        // Hitung total user
        $totalUsers = \App\Models\User::count();

        // Hitung total role
        $totalRoles = \App\Models\Role::count();

        // Hitung total kategori
        $totalCategories = \App\Models\Category::count();

        // Hitung total produk
        $totalProducts = \App\Models\Product::count();

        // Hitung total produk per kategori (opsional untuk chart)
        $productsPerCategory = \App\Models\Category::withCount('products')->get();

        // Hitung total transaksi (receipt)
        $totalReceipts = \App\Models\Receipt::count();

        // Hitung transaksi selesai (status = 1, misalnya)
        $completedReceipts = \App\Models\Receipt::where('status', 'Selesai')->count();

        // Hitung transaksi belum selesai (status != 1)
        $pendingReceipts = \App\Models\Receipt::where('status', "Terima Hp")->count();

        // Kirim data ke view dashboard
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalRoles' => $totalRoles,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'productsPerCategory' => $productsPerCategory,
            'totalReceipts' => $totalReceipts,
            'completedReceipts' => $completedReceipts,
            'pendingReceipts' => $pendingReceipts,
        ]);
    }

    

    
}
