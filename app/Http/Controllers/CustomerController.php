<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // FIXED: Menambahkan fitur pencarian berdasarkan nama atau nomor telepon
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%')
                  ->orWhere('phone_number', 'like', '%' . $request->name . '%');
        }

        $customers = $query->latest()->paginate(5);

        return view('pages.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // FIXED: Menambahkan validasi agar data yang masuk ke database terjamin kelengkapannya
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|max:15'
        ]);

        // FIXED: Memperbaiki typo variabel dari $cutomer menjadi $customer
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        
        // FIXED: Memperbaiki nama folder view dari 'custome' menjadi 'customer'
        return view('pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'         => 'required|email|unique:customers,email,' . $id,
            'phone_number' => 'required|string|max:15'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // FIXED: Merapikan penamaan variabel dan menambahkan flash message success saat hapus data
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer successfully deleted');
    }
}