<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('branch')->latest('name');

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->where(function ($customerQuery) use ($search) {
                $customerQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $customers = $query->paginate(12)->withQueryString();
        $branches = Branch::orderBy('branch_name')->get();

        return view('owner.customers', compact('customers', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'branch_id' => 'nullable|exists:branches,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        Customer::create($validated);

        return redirect()->route('owner.customers')->with('success', 'Customer contact added successfully.');
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'branch_id' => 'nullable|exists:branches,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $customer->update($validated);

        return redirect()->route('owner.customers')->with('success', 'Customer contact updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('owner.customers')->with('success', 'Customer contact removed.');
    }
}