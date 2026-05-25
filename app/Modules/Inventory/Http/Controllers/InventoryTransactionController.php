<?php

namespace App\Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Inventory\Models\InventoryItem;
use App\Modules\Inventory\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    /**
     * Display the Stock Move (In) page.
     */
    public function stockMove()
    {
        $items = InventoryItem::orderBy('name')->get();
        $transactions = InventoryTransaction::with(['inventoryItem', 'actor'])
            ->where('type', 'move_in')
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        return view('inventory.transactions.stock_move', compact('items', 'transactions'));
    }

    /**
     * Display the Stock Out (Dispatch) page.
     */
    public function stockOut()
    {
        $items = InventoryItem::orderBy('name')->get();
        $transactions = InventoryTransaction::with(['inventoryItem', 'actor'])
            ->where('type', 'stock_out')
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        return view('inventory.transactions.stock_out', compact('items', 'transactions'));
    }

    /**
     * Display the Stock Correction page.
     */
    public function stockCorrection()
    {
        $items = InventoryItem::orderBy('name')->get();
        $transactions = InventoryTransaction::with(['inventoryItem', 'actor'])
            ->where('type', 'correction')
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        return view('inventory.transactions.stock_correction', compact('items', 'transactions'));
    }

    /**
     * Store a new inventory transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'type' => 'required|in:move_in,stock_out,correction',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'correction_action' => 'nullable|required_if:type,correction|in:add,subtract',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $item = InventoryItem::lockForUpdate()->findOrFail($validated['inventory_item_id']);
            $quantity = (int) $validated['quantity'];

            // Store transaction
            InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => $validated['type'],
                'quantity' => $quantity, // We store the absolute magnitude in the transaction table
                'transaction_date' => $validated['transaction_date'],
                'reference' => $validated['reference'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
                'actor_id' => $request->user()->id ?? null,
            ]);

            // Update Item Master balances
            if ($validated['type'] === 'move_in') {
                $item->quantity_acquired += $quantity;
                $item->quantity_remaining += $quantity;
            } elseif ($validated['type'] === 'stock_out') {
                $item->quantity_distributed += $quantity;
                $item->quantity_remaining -= $quantity;
            } elseif ($validated['type'] === 'correction') {
                if ($validated['correction_action'] === 'add') {
                    $item->quantity_remaining += $quantity;
                } else {
                    $item->quantity_remaining -= $quantity;
                }
            }

            // Sync total quantity based on remaining + distributed?
            // Usually, quantity is the base metric. We'll update the main quantity to match remaining if that's how it's used.
            $item->quantity = $item->quantity_remaining;

            $item->save();
        });

        $redirects = [
            'move_in' => 'inventory.stock-move',
            'stock_out' => 'inventory.stock-out',
            'correction' => 'inventory.stock-correction',
        ];

        $route = $redirects[$validated['type']] ?? 'inventory.index';

        return redirect()->route($route)->with('success', 'Transaction recorded successfully.');
    }
}
