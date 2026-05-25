@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Inventory Items <span class="text-blue-600 dark:text-blue-400">Master</span></h1>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Manage your inventory, import from Excel, or export data.</p>
        </div>
        <div class="flex gap-1.5">
            <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <a href="{{ route('inventory.export') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Item
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-rose-50 p-4 text-sm text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/30">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="border-b border-slate-200/40 p-3 dark:border-slate-800">
            <form action="{{ route('inventory.index') }}" method="GET" class="flex max-w-md items-center gap-2">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Item Code or Description..." class="w-full rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 pl-8 pr-3 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                </div>
                <button type="submit" class="rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">Search</button>
                @if(request('search'))
                    <a href="{{ route('inventory.index') }}" class="px-3.5 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-all duration-200">Clear</a>
                @endif
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                    <tr>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Category</th>
                        <th class="px-3 py-2">Unit</th>
                        <th class="px-3 py-2">Qty</th>
                        <th class="px-3 py-2">Acquired</th>
                        <th class="px-3 py-2">Distributed</th>
                        <th class="px-3 py-2">Remaining</th>
                        <th class="px-3 py-2">Supplier</th>
                        <th class="px-3 py-2">Brand</th>
                        <th class="px-3 py-2">Remarks</th>
                        <th class="px-3 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-850">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-colors">
                            <td class="whitespace-nowrap px-3 py-2.5 font-semibold text-slate-900 dark:text-white text-xs">{{ $item->name }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->category }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->unit }}</td>
                            <td class="px-3 py-2.5 text-xs font-medium">{{ $item->quantity }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->quantity_acquired }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->quantity_distributed }}</td>
                            <td class="px-3 py-2.5 text-xs font-medium {{ $item->quantity_remaining <= 0 ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }}">{{ $item->quantity_remaining }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->supplier }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->brand }}</td>
                            <td class="px-3 py-2.5 text-xs text-slate-500 dark:text-slate-400">{{ $item->remarks ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-right text-xs">
                                <div class="inline-flex gap-1">
                                    <button type="button" onclick="openEditModal({{ $item->toJson() }})" class="inline-flex items-center gap-1 rounded border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-950/40 px-2 py-1 text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-100/80 dark:hover:bg-blue-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Edit</button>
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->name) }}')" class="inline-flex items-center gap-1 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2 py-1 text-[10px] font-bold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-3 py-6 text-center text-xs text-slate-500">
                                No items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-850 p-3 sm:p-4 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/50 dark:bg-slate-900/50 rounded-b-xl backdrop-blur-md">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-1.5 text-xs text-slate-550 dark:text-slate-400">
                @foreach(request()->except('per_page', 'page') as $key => $value)
                    @if(is_array($value))
                        @foreach($value as $k => $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <span>Show</span>
                <input type="number" name="per_page" value="{{ $items->perPage() }}" min="1" max="100" 
                       class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                       onchange="this.form.submit()">
                <span>entries</span>
            </form>
            @if($items->hasPages())
                <div>
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('modals')
<div id="item-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add New Item</h3>
                <button type="button" onclick="closeItemModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="item-form" method="POST" action="{{ route('inventory.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                        <input type="text" name="name" id="input_name" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                        <select name="category" id="input_category" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">-- Select Category --</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Consumables">Consumables</option>
                            <option value="Tools">Tools</option>
                            <option value="Materials">Materials</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity</label>
                        <input type="number" name="quantity" id="input_quantity" required min="0" value="0" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Unit</label>
                        <select name="unit" id="input_unit" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">-- Select Unit --</option>
                            <option value="pcs">Pcs</option>
                            <option value="boxes">Boxes</option>
                            <option value="sets">Sets</option>
                            <option value="packs">Packs</option>
                            <option value="kgs">Kgs</option>
                            <option value="meters">Meters</option>
                            <option value="liters">Liters</option>
                            <option value="rolls">Rolls</option>
                            <option value="bundles">Bundles</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity Acquired</label>
                        <input type="number" name="quantity_acquired" id="input_quantity_acquired" required min="0" value="0" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity Distributed</label>
                        <input type="number" name="quantity_distributed" id="input_quantity_distributed" required min="0" value="0" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quantity Remaining</label>
                        <input type="number" name="quantity_remaining" id="input_quantity_remaining" required min="0" value="0" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Supplier</label>
                        <input type="text" name="supplier" id="input_supplier" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Brand (if applicable)</label>
                        <input type="text" name="brand" id="input_brand" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Remarks (Optional)</label>
                        <input type="text" name="remarks" id="input_remarks" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeItemModal()" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" id="modal-submit-btn" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Import -->
<div id="import-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Import Inventory from Excel</h3>
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('inventory.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-slate-400 dark:file:bg-slate-700 dark:file:text-slate-300">
                    <p class="mt-2 text-xs text-slate-500">Ensure the file has headers: name, category, quantity, unit, quantity_acquired, quantity_distributed, quantity_remaining, supplier, brand, remarks.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Import File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Delete -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">Delete Item</h3>
            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">Are you sure you want to delete item <span id="delete-item-code" class="font-bold"></span>? This action cannot be undone.</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inventoryUrl = "{{ route('inventory.index') }}";
    
    function openAddModal() {
        document.getElementById('modal-title').textContent = 'Add New Item';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('item-form').action = inventoryUrl;
        
        document.getElementById('input_name').value = '';
        document.getElementById('input_category').value = '';
        document.getElementById('input_quantity').value = '0';
        document.getElementById('input_unit').value = '';
        document.getElementById('input_quantity_acquired').value = '0';
        document.getElementById('input_quantity_distributed').value = '0';
        document.getElementById('input_quantity_remaining').value = '0';
        document.getElementById('input_supplier').value = '';
        document.getElementById('input_brand').value = '';
        document.getElementById('input_remarks').value = '';
        
        document.getElementById('modal-submit-btn').textContent = 'Save Item';
        document.getElementById('item-modal').classList.remove('hidden');
    }

    function openEditModal(item) {
        document.getElementById('modal-title').textContent = 'Edit Item: ' + item.name;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('item-form').action = inventoryUrl + '/' + item.id;
        
        document.getElementById('input_name').value = item.name;
        document.getElementById('input_category').value = item.category || '';
        document.getElementById('input_quantity').value = item.quantity;
        document.getElementById('input_unit').value = item.unit || '';
        document.getElementById('input_quantity_acquired').value = item.quantity_acquired;
        document.getElementById('input_quantity_distributed').value = item.quantity_distributed;
        document.getElementById('input_quantity_remaining').value = item.quantity_remaining;
        document.getElementById('input_supplier').value = item.supplier || '';
        document.getElementById('input_brand').value = item.brand || '';
        document.getElementById('input_remarks').value = item.remarks || '';
        
        document.getElementById('modal-submit-btn').textContent = 'Update Item';
        document.getElementById('item-modal').classList.remove('hidden');
    }

    function closeItemModal() {
        document.getElementById('item-modal').classList.add('hidden');
    }

    function openDeleteModal(id, code) {
        document.getElementById('delete-item-code').textContent = code;
        document.getElementById('delete-form').action = inventoryUrl + '/' + id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
