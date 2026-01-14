<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::with(['category', 'lastTransaction'])
            ->orderBy('name')
            ->get();
            
        $lowStockItems = $items->filter(fn($item) => $item->quantity <= $item->reorder_level);
        
        return view('admin.inventory.index', [
            'items' => $items,
            'lowStockItems' => $lowStockItems,
            'totalItems' => $items->count(),
            'totalValue' => $items->sum(fn($item) => $item->quantity * $item->unit_price),
        ]);
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.inventory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item = InventoryItem::create($validated);

        // Record initial stock
        if ($validated['quantity'] > 0) {
            $item->transactions()->create([
                'type' => 'in',
                'quantity' => $validated['quantity'],
                'unit_price' => $validated['unit_price'],
                'total_price' => $validated['quantity'] * $validated['unit_price'],
                'notes' => 'Initial stock',
                'transaction_date' => now(),
            ]);
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function edit(InventoryItem $inventory)
    {
        $categories = \App\Models\Category::all();
        return view('admin.inventory.edit', [
            'item' => $inventory->load('category'),
            'categories' => $categories
        ]);
    }

    public function update(Request $request, InventoryItem $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventory)
    {
        if ($inventory->quantity > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete item with remaining stock. Please adjust stock to zero first.');
        }

        $inventory->delete();
        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }

    public function adjustStock(Request $request, InventoryItem $inventory)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required_if:type,in|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        return DB::transaction(function () use ($inventory, $validated) {
            $quantity = $validated['type'] === 'in' 
                ? $validated['quantity'] 
                : -$validated['quantity'];

            $totalPrice = $validated['type'] === 'in'
                ? $validated['quantity'] * $validated['unit_price']
                : null;

            $inventory->transactions()->create([
                'type' => $validated['type'],
                'quantity' => abs($quantity),
                'unit_price' => $validated['unit_price'] ?? $inventory->unit_price,
                'total_price' => $totalPrice,
                'notes' => $validated['notes'],
                'transaction_date' => $validated['transaction_date'],
            ]);

            // Update item quantity
            $inventory->increment('quantity', $quantity);

            return redirect()->back()
                ->with('success', 'Stock adjusted successfully.');
        });
    }

    public function transactions(InventoryItem $inventory)
    {
        $transactions = $inventory->transactions()
            ->latest('transaction_date')
            ->paginate(20);
            
        return view('admin.inventory.transactions', [
            'item' => $inventory,
            'transactions' => $transactions
        ]);
    }
}
