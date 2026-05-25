@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Stock Move (In)</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Record incoming supplies and deliveries to your inventory.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Record Stock In
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-800 dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Item</th>
                        <th class="px-6 py-4">Quantity In</th>
                        <th class="px-6 py-4">Reference (PO/Receipt)</th>
                        <th class="px-6 py-4">Remarks</th>
                        <th class="px-6 py-4">Recorded By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($transactions as $txn)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <td class="px-6 py-4">{{ $txn->transaction_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $txn->inventoryItem->name ?? 'Deleted Item' }}</td>
                            <td class="px-6 py-4 font-medium text-emerald-600">+{{ $txn->quantity }}</td>
                            <td class="px-6 py-4">{{ $txn->reference ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $txn->remarks ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $txn->actor->name ?? 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                No stock move records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('modals')
<div id="add-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Record Stock In</h3>
                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('inventory.transactions.store') }}">
                @csrf
                <input type="hidden" name="type" value="move_in">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Item</label>
                        <select name="inventory_item_id" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">-- Select Item --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Cur: {{ $item->quantity_remaining }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Date Received</label>
                        <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity to Add</label>
                        <input type="number" name="quantity" required min="1" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Reference (PO / Receipt No.)</label>
                        <input type="text" name="reference" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Remarks</label>
                        <textarea name="remarks" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 dark:border-slate-700 pt-4">
                    <button type="button" onclick="closeAddModal()" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700 shadow-sm shadow-blue-500/30">Save Stock In</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openAddModal() {
        document.getElementById('add-modal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('add-modal').classList.add('hidden');
    }
</script>
@endpush
@endsection
