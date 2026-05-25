@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Supplier List Master</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your suppliers, import from Excel, or export data.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <a href="{{ route('supplier.export') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Supplier
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-rose-50 p-4 text-sm text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/30">
            {{ session('error') }}
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

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="border-b border-slate-200 p-4 dark:border-slate-700">
            <form method="GET" action="{{ route('supplier.index') }}" class="flex max-w-md items-center gap-2">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, category, status..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-9 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <button type="submit" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">Search</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Pos/Dept</th>
                        <th class="px-6 py-4">Contact No.</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4">Proof (Link)</th>
                        <th class="px-6 py-4">Remarks</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($suppliers as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $item->name }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $sColors = [
                                        'paid & settled' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'delivered' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'ended' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
                                        'cancelled' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400',
                                        'confirmed/booked' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                    ];
                                    $colorClass = $sColors[$item->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
                                @endphp
                                <select onchange="updateInlineStatus(this, {{ $item->id }}, 'supplier')" class="text-xs font-medium rounded-full px-2.5 py-1 appearance-none border-0 cursor-pointer focus:ring-2 focus:ring-blue-500 {{ $colorClass }}">
                                    <option value="" {{ !$item->status ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">-- Select --</option>
                                    <option value="paid & settled" {{ $item->status == 'paid & settled' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Paid & Settled</option>
                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Delivered</option>
                                    <option value="ended" {{ $item->status == 'ended' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Ended</option>
                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Cancelled</option>
                                    <option value="confirmed/booked" {{ $item->status == 'confirmed/booked' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Confirmed/Booked</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">{{ $item->category }}</td>
                            <td class="px-6 py-4">{{ $item->contact }}</td>
                            <td class="px-6 py-4">{{ $item->position_dept }}</td>
                            <td class="px-6 py-4">{{ $item->contact_no }}</td>
                            <td class="px-6 py-4">{{ $item->email }}</td>
                            <td class="px-6 py-4">{{ $item->location }}</td>
                            <td class="px-6 py-4">
                                @if($item->proof_of_completion)
                                    <a href="{{ $item->proof_of_completion }}" target="_blank" class="text-blue-600 hover:underline">View Link</a>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-[200px] truncate" title="{{ $item->remarks }}">{{ $item->remarks }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button type="button" onclick="openEditModal({{ $item }})" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium">Edit</button>
                                <br>
                                <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->name) }}')" class="text-rose-600 hover:text-rose-800 dark:hover:text-rose-400 font-medium mt-1">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-8 text-center text-slate-500">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($suppliers->hasPages())
            <div class="border-t border-slate-200 dark:border-slate-700 p-4">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
</div>

@push('modals')
<div id="supplier-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add New Supplier</h3>
                <button type="button" onclick="closeSupplierModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="supplier-form" method="POST" action="{{ route('supplier.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Name (Supplier/Company) <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="input_name" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                        <select name="status" id="input_status" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">-- Select Status --</option>
                            <option value="paid & settled">Paid & Settled</option>
                            <option value="delivered">Delivered</option>
                            <option value="ended">Ended</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="confirmed/booked">Confirmed/Booked</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                        <input list="supplier_categories" type="text" name="category" id="input_category" placeholder="Select or type category..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <datalist id="supplier_categories">
                            <option value="Raw Materials">
                            <option value="Equipment & Machinery">
                            <option value="Hardware & Tools">
                            <option value="Logistics & Transport">
                            <option value="Packaging">
                            <option value="Office Supplies">
                            <option value="IT & Software">
                        </datalist>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact (Person)</label>
                        <input type="text" name="contact" id="input_contact" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Position / Dept</label>
                        <input type="text" name="position_dept" id="input_position_dept" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact No.</label>
                        <input type="text" name="contact_no" id="input_contact_no" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input type="email" name="email" id="input_email" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Location</label>
                        <input type="text" name="location" id="input_location" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Proof of Completion (Link URL)</label>
                        <input type="text" name="proof_of_completion" id="input_proof" placeholder="https://..." class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Remarks (Optional)</label>
                        <input type="text" name="remarks" id="input_remarks" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeSupplierModal()" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" id="modal-submit-btn" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Supplier</button>
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
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Import Suppliers from Excel</h3>
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('supplier.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-slate-400 dark:file:bg-slate-700 dark:file:text-slate-300">
                    <p class="mt-2 text-xs text-slate-500">Ensure the file has headers: name, status, category, contact, position_dept, contact_no, email, location, proof_of_completion, remarks.</p>
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
            <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">Delete Supplier</h3>
            <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">Are you sure you want to delete <span id="delete-item-name" class="font-bold"></span>? This action cannot be undone.</p>
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
    const supplierUrl = "{{ route('supplier.index') }}";
    
    function openAddModal() {
        document.getElementById('modal-title').textContent = 'Add New Supplier';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('supplier-form').action = supplierUrl;
        
        document.getElementById('input_name').value = '';
        document.getElementById('input_status').value = '';
        document.getElementById('input_category').value = '';
        document.getElementById('input_contact').value = '';
        document.getElementById('input_position_dept').value = '';
        document.getElementById('input_contact_no').value = '';
        document.getElementById('input_email').value = '';
        document.getElementById('input_location').value = '';
        document.getElementById('input_proof').value = '';
        document.getElementById('input_remarks').value = '';
        
        document.getElementById('modal-submit-btn').textContent = 'Save Supplier';
        document.getElementById('supplier-modal').classList.remove('hidden');
    }

    function openEditModal(item) {
        document.getElementById('modal-title').textContent = 'Edit Supplier: ' + item.name;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('supplier-form').action = supplierUrl + '/' + item.id;
        
        document.getElementById('input_name').value = item.name;
        document.getElementById('input_status').value = item.status || '';
        document.getElementById('input_category').value = item.category || '';
        document.getElementById('input_contact').value = item.contact || '';
        document.getElementById('input_position_dept').value = item.position_dept || '';
        document.getElementById('input_contact_no').value = item.contact_no || '';
        document.getElementById('input_email').value = item.email || '';
        document.getElementById('input_location').value = item.location || '';
        document.getElementById('input_proof').value = item.proof_of_completion || '';
        document.getElementById('input_remarks').value = item.remarks || '';
        
        document.getElementById('modal-submit-btn').textContent = 'Update Supplier';
        document.getElementById('supplier-modal').classList.remove('hidden');
    }

    function closeSupplierModal() {
        document.getElementById('supplier-modal').classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-item-name').textContent = name;
        document.getElementById('delete-form').action = supplierUrl + '/' + id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function updateInlineStatus(selectElement, id, type) {
        selectElement.disabled = true;
        let originalText = selectElement.options[selectElement.selectedIndex].text;
        
        fetch('/' + type + '/' + id + '/status', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: selectElement.value })
        })
        .then(response => response.json())
        .then(data => {
            selectElement.disabled = false;
            if(data.success) {
                // Reload to refresh colors and table state smoothly
                window.location.reload(); 
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            selectElement.disabled = false;
            alert('Error updating status: ' + error);
        });
    }
</script>
@endpush
@endsection
