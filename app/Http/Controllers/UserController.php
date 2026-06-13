<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan Eloquent ORM agar konsisten dengan method lainnya
        $users = User::query()
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc') // Biar user terbaru muncul di paling atas
            ->paginate(5);

        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        // Validasi input wajib diisi dan email harus unik
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string', // Biar sesuai persiapan pembagian role nanti
        ]);

        // Hash password sebelum disimpan
        $validatedData['password'] = Hash::make($request->input('password'));

        User::create($validatedData);

        return redirect()->route('user.index')->with('success', 'User successfully created.');
    }

    public function show($id)
    {
        // Kosongkan atau redirect jika tidak digunakan
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input, email unik mengabaikan ID user ini sendiri saat update
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6', // Boleh kosong kalau gak mau ganti password
            'role' => 'required|string',
        ]);

        // FIX LOGIC: Jika password diisi, lakukan hash. Jika kosong, hapus dari array agar tidak menimpa password lama
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('user.index')->with('success', 'User successfully updated.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User successfully deleted.');
    }
}