<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier; // Import model Supplier untuk relasi dropdown
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan Eloquent dengan Eager Loading ('supplier') agar bisa manggil nama supplier di tabel index
        $inventories = Inventory::with('supplier')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pages.inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data supplier untuk dilempar ke dropdown Form Create
        $suppliers = Supplier::all();
        return view('pages.inventory.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data sesuai kolom di migration database
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50', // Contoh: pcs, box, sachet
            'supplier_id' => 'required|exists:suppliers,id', // Memastikan ID supplier yang dipilih emang ada
        ]);

        Inventory::create($validatedData);

        return redirect()->route('inventory.index')->with('success', 'Inventory successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        return redirect()->route('inventory.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        // Ambil semua data supplier untuk dilempar ke dropdown Form Edit
        $suppliers = Supplier::all();
        return view('pages.inventory.edit', compact('inventory', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        // Validasi data sebelum diupdate
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $inventory->update($validatedData);

        return redirect()->route('inventory.index')->with('success', 'Inventory successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory successfully deleted.');
    }
}