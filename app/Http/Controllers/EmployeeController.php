<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan murni dengan kolom di migration database
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric',
            'date_of_birth' => 'required|date',
            'date_of_joining' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        // Otomatis memasukkan user_id dari akun yang sedang login membuat data ini
        $validatedData['user_id'] = auth()->id();

        Employee::create($validatedData);

        return redirect()->route('employee.index')->with('success', 'Employee successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return redirect()->route('employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('pages.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric',
            'date_of_birth' => 'required|date',
            'date_of_joining' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employee.index')->with('success', 'Employee successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employee.index')->with('with', 'Employee successfully deleted.');
    }
}