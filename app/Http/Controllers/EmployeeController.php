<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\LastOperationType;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
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

        return redirect()->route('employees.index')->with('message', 'Employee created.');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/EmployeeForm', [
            'employee' => $employee,
            'formMode' => 'edit',
        ]);
    }

    public function update(Employee $employee, Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($employee->id)],
            'phone_number' => [
                'required', 'digits:10', Rule::unique('employees', 'phone_number')->ignore($employee->id),
            ],
        ]);

        $validateData['last_operation'] = LastOperationType::UPDATE;

        $employee->update($validateData);

        return redirect()->route('employees.index')->with('message', 'Employee updated.');
    }

    public function updatePassword(Employee $employee, Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $validateData['last_operation'] = LastOperationType::UPDATE;

        if ($employee->password !== bcrypt($validateData['password'])) {
            throw ValidationException::withMessages([
                'current_password' => 'The provided password does not match the current password.',
            ]);
        }

        $employee->update($validateData);

        return redirect()->route('employees.index')->with('message', 'Employee password updated.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('message', 'Employee deleted.');
    }
}
