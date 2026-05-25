<?php

namespace App\Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Inventory\Models\InventoryItem;
use App\Modules\Inventory\Exports\InventoryItemExport;
use App\Modules\Inventory\Imports\InventoryItemImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryItemController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $perPage = max(1, min(100, (int) $request->integer('per_page', 20)));
        $items = $query->latest()->paginate($perPage)->withQueryString();

        return view('inventory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:255',
            'quantity_acquired' => 'required|integer|min:0',
            'quantity_distributed' => 'required|integer|min:0',
            'quantity_remaining' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory.index')->with('success', 'Item added successfully');
    }

    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:255',
            'quantity_acquired' => 'required|integer|min:0',
            'quantity_distributed' => 'required|integer|min:0',
            'quantity_remaining' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $item->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully');
    }

    public function destroy(InventoryItem $item)
    {
        $item->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully');
    }

    public function export()
    {
        return Excel::download(new InventoryItemExport, 'inventory_items.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        Excel::import(new InventoryItemImport, $request->file('file'));

        return redirect()->route('inventory.index')->with('success', 'Items imported successfully');
    }
}
