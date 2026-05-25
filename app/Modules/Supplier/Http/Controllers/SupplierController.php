<?php

namespace App\Modules\Supplier\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Supplier\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Supplier\Exports\SupplierExport;
use App\Modules\Supplier\Imports\SupplierImport;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->latest()->paginate(15);
        
        return view('supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'position_dept' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'proof_of_completion' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'position_dept' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'proof_of_completion' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    public function updateStatus(Request $request, Supplier $supplier)
    {
        $request->validate(['status' => 'nullable|string|max:255']);
        $supplier->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new SupplierExport, 'suppliers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new SupplierImport, $request->file('file'));
            return redirect()->route('supplier.index')->with('success', 'Suppliers imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('supplier.index')->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
