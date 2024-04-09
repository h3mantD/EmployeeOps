<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

final class EmployeeController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employees/EmployeeForm', [
            'employee' => null,
            'formMode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:employees,email'],
            'phone_number' => ['required', 'digits:10', 'unique:employees,phone_number'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Employee::create($validateData);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/EmployeeForm', [
            'employee' => $employee,
            'formMode' => 'edit',
        ]);
    }

    public function update(Employee $employee)
    {
        // Validate the request...
        // Update the employee...
        return redirect()->route('employees.index');
    }
}
