<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib import ini buat handle hapus file gambar

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pakai Eloquent biar konsisten
        $categories = Category::query()
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan nullable di database
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // Logic upload gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder storage/app/public/category
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }

        Category::create($validatedData);

        return redirect()->route('category.index')->with('success', 'Category successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Pake findOrFail biar kalau ID ngaco langsung dialihin ke 404
        $category = Category::findOrFail($id);

        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $category = Category::findOrFail($id);

        // Logic update gambar
        if ($request->hasFile('image')) {
            // Cek apakah category ini sebelumnya udah punya gambar, kalau ada hapus dulu biar gak menuh-menuhin storage
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            // Simpan gambar yang baru
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }

        $category->update($validatedData);

        return redirect()->route('category.index')->with('success', 'Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus file gambar fisiknya dari storage sebelum datanya dihapus dari database
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Data Berhasil Di Hapus');
    }
}