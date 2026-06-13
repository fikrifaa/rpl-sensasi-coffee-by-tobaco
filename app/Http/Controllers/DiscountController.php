<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan Eloquent dan mengurutkan berdasarkan data terbaru
        $discounts = Discount::query()
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('pages.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data sebelum masuk database
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:fixed,percentage',
            'value'        => 'required|numeric|min:0',
            'status'       => 'required|in:active,inactive',
            'expired_date' => 'nullable|date',
        ]);

        Discount::create($request->all());

        return redirect()->route('discount.index')->with('success', 'Discount created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('pages.discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        // Validasi input data sebelum melakukan update
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:fixed,percentage',
            'value'        => 'required|numeric|min:0',
            'status'       => 'required|in:active,inactive',
            'expired_date' => 'nullable|date',
        ]);

        $discount->update($request->all());

        return redirect()->route('discount.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discount.index')->with('success', 'Discount deleted successfully.');
    }
}