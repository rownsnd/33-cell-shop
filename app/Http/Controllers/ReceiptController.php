<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    // LIST semua resi
    public function index(Request $request)
    {
        // Hitung total transaksi (receipt)
        $totalReceipts = Receipt::count();

        // Hitung transaksi selesai (status = 1, misalnya)
        $completedReceipts = Receipt::where('status', 'Selesai')->count();

        // Hitung transaksi belum selesai (status != 1)
        $pendingReceipts = Receipt::where('status', "Terima Hp")->count();
        $receipts = Receipt::with(['product', 'user']);
        
        if ($request->search) {
            $receipts->where(function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->sort == 'latest') {
            $receipts->latest();
        } elseif ($request->sort == 'oldest') {
            $receipts->oldest();
        }

        $receipts = $receipts->get();

        $products = Product::all();
        $users = User::all();

        return view('admin.receipt', compact('receipts', 'products', 'users','pendingReceipts', 'completedReceipts', 'totalReceipts'));
    }
    // TAMPILKAN form tambah resi
    public function create()
    {
        $products = Product::all();
        $users = User::all();
        return view('admin.receipt', compact('products', 'users'));
    }

    // SIMPAN resi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'estimate' => 'required|date',
        ]);
    
        // Generate code otomatis
        $today = now()->format('Ymd');
        $latestReceipt = Receipt::whereDate('created_at', now()->toDateString())->count() + 1;
        $code = 'RCPT-' . $today . '-' . str_pad($latestReceipt, 4, '0', STR_PAD_LEFT);
    
        // Tambahkan code ke data yang akan disimpan
        $validated['code'] = $code;

        // Simpan
        Receipt::create($validated);
        
        return redirect()->route('receipt.index')->with('success', 'Resi berhasil ditambahkan dengan kode: ' . $code);
    }
    
    
    

    // TAMPILKAN form edit
    public function edit($id)
    {
        $receipt = Receipt::findOrFail($id);
        $products = \App\Models\Product::all();
        $users = \App\Models\User::all();
        return view('admin.receipt', compact('receipt', 'products', 'users'));
    }

    // UPDATE data resi
    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:receipts,code,' . $receipt->id,
            'status' => 'required|string|max:50',
            'estimate' => 'required|date',
        ]);

        $receipt->update($validated);

        return redirect()->route('receipt.index')->with('success', 'Resi berhasil diubah.');
    }

    // HAPUS resi
    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return redirect()->route('receipt.index')->with('success', 'Resi berhasil dihapus.');
    }

    public function customer()
    {   
        return view('receipt');
    }
    public function track(Request $request)
    {
        $code = $request->code;
        $receipt = null;

        if ($code) {
            $receipt = \App\Models\Receipt::with('product')
                ->where('code', $code)
                ->first();
        }

        return view('receipt', compact('receipt'));
    }

}
