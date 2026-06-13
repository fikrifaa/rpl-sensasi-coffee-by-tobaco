<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ditambahkan Eager Loading 'discount' agar mempermudah pemanggilan data diskon di tabel
        $products = Product::with(['category', 'discount'])
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $discounts = Discount::all(); // Mengambil semua opsi diskon untuk dropdown di form
        
        return view('pages.product.create', compact('categories', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'discount_id'  => 'nullable|exists:discounts,id', // Validasi discount_id (boleh kosong)
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $validatedData['is_available'] = $request->has('is_available') ? true : false;

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validatedData);

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $discounts = Discount::all(); // Mengambil semua opsi diskon untuk dropdown di form edit

        return view('pages.product.edit', compact('categories', 'product', 'discounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'discount_id'  => 'nullable|exists:discounts,id', // Validasi discount_id (boleh kosong)
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($id);

        $validatedData['is_available'] = $request->has('is_available') ? true : false;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validatedData);

        // FIXED: Mengubah ->with('with', ...) yang typo menjadi ->with('success', ...) agar alert notifikasi menyala
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // 🔥 LOGIKA PROTEKSI DB CONSTRAINT: Cek riwayat transaksi di tabel order_items
        $hasTransactions = DB::table('order_items')->where('id_product', $id)->exists();

        if ($hasTransactions) {
            // Jika ada transaksi, batalkan proses hapus dan kirim pesan error yang ramah ke user
            return redirect()->route('product.index')->with('error', 'Gagal menghapus! Produk "' . $product->name . '" tidak bisa dihapus karena sudah memiliki riwayat transaksi/pembelian.');
        }

        // Jika aman dari keterikatan data transaksi, hapus file gambar dari storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data produk dari database secara permanen
        $product->delete();
        
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }

    /**
     * API Endpoint for POS / Mobile Frontend
     */
    public function get()
    {
        // Menyertakan data diskon ke dalam output JSON API
        $products = Product::with(['category', 'discount'])->get();
        return response()->json(['status' => 200, 'data' => $products], 200);
    }
}