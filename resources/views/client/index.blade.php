@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Client List <span class="text-blue-600 dark:text-blue-400">Master</span></h1>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Manage your clients, import from Excel, or export data.</p>
        </div>
        <div class="flex gap-1.5">
            <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <a href="{{ route('client.export') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Client
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

    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="border-b border-slate-200/40 p-3 dark:border-slate-800">
            <form method="GET" action="{{ route('client.index') }}" class="flex max-w-md items-center gap-2">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by company, contact person, status..." class="w-full rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 pl-8 pr-3 text-xs focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                </div>
                <button type="submit" class="rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">Search</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                    <tr>
                        <th class="px-3 py-2">Company</th>
                        <th class="px-3 py-2">Status / Remarks</th>
                        <th class="px-3 py-2">Category</th>
                        <th class="px-3 py-2">Pricing</th>
                        <th class="px-3 py-2">Items & Inclusions</th>
                        <th class="px-3 py-2">Contact Person</th>
                        <th class="px-3 py-2">Pos/Dept</th>
                        <th class="px-3 py-2">Contact No.</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Location</th>
                        <th class="px-3 py-2">Quotation (Link)</th>
                        <th class="px-3 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-850">
                    @forelse($clients as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-colors">
                            <td class="whitespace-nowrap px-3 py-2.5 font-semibold text-slate-900 dark:text-white text-xs">{{ $item->company }}</td>
                            <td class="px-3 py-2.5 text-xs min-w-[200px]">
                                <div class="flex flex-col gap-1">
                                    <div>
                                        @php
                                            $cColors = [
                                                'to contact' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800',
                                                'contacted - waiting reply' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/35 dark:text-amber-400 border border-amber-200 dark:border-amber-800',
                                                'quotation received' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/35 dark:text-blue-400 border border-blue-200 dark:border-blue-800',
                                                'paid & settled' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/35 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800',
                                                'delivered' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/35 dark:text-purple-400 border border-purple-200 dark:border-purple-800',
                                                'cancelled' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/35 dark:text-rose-400 border border-rose-200 dark:border-rose-800',
                                            ];
                                            $colorClass = $cColors[$item->status] ?? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800';
                                        @endphp
                                        <select onchange="updateInlineStatus(this, {{ $item->id }}, 'client')" class="text-[10px] font-bold rounded-full px-2 py-0.5 appearance-none border-0 cursor-pointer focus:ring-1 focus:ring-blue-500 {{ $colorClass }}">
                                            <option value="" {{ !$item->status ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">-- Select --</option>
                                            <option value="to contact" {{ $item->status == 'to contact' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">To Contact</option>
                                            <option value="contacted - waiting reply" {{ $item->status == 'contacted - waiting reply' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">Waiting Reply</option>
                                            <option value="quotation received" {{ $item->status == 'quotation received' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">Quotation Received</option>
                                            <option value="paid & settled" {{ $item->status == 'paid & settled' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">Paid & Settled</option>
                                            <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">Delivered</option>
                                            <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }} class="bg-white text-slate-900 dark:bg-slate-905 dark:text-white">Cancelled</option>
                                        </select>
                                    </div>
                                    @if($item->remarks)
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 truncate max-w-[180px]" title="{{ $item->remarks }}">{{ $item->remarks }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->category }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->pricing }}</td>
                            <td class="px-3 py-2.5 text-xs max-w-[150px] truncate" title="{{ $item->items_inclusions }}">{{ $item->items_inclusions }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->contact_person }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->position_dept }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->contact_no }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->email }}</td>
                            <td class="px-3 py-2.5 text-xs">{{ $item->location }}</td>
                            <td class="px-3 py-2.5 text-xs">
                                @if($item->quotation)
                                    <a href="{{ $item->quotation }}" target="_blank" class="text-blue-600 hover:underline font-semibold">View Link</a>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-right text-xs">
                                <div class="inline-flex gap-1">
                                    <button type="button" onclick="openEditModal({{ $item }})" class="inline-flex items-center gap-1 rounded border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-950/40 px-2 py-1 text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-100/80 dark:hover:bg-blue-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Edit</button>
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->company) }}')" class="inline-flex items-center gap-1 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2 py-1 text-[10px] font-bold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-3 py-6 text-center text-xs text-slate-500">No clients found.</td>
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
                <input type="number" name="per_page" value="{{ $clients->perPage() }}" min="1" max="100" 
                       class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                       onchange="this.form.submit()">
                <span>entries</span>
            </form>
            @if($clients->hasPages())
                <div>
                    {{ $clients->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('modals')
<div id="client-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-3xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add New Client</h3>
                <button type="button" onclick="closeClientModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="client-form" method="POST" action="{{ route('client.store') }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Company <span class="text-rose-500">*</span></label>
                        <input type="text" name="company" id="input_company" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                        <select name="status" id="input_status" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">-- Select Status --</option>
                            <option value="to contact">To Contact</option>
                            <option value="contacted - waiting reply">Contacted - Waiting Reply</option>
                            <option value="quotation received">Quotation Received</option>
                            <option value="paid & settled">Paid & Settled</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                        <input list="client_categories" type="text" name="category" id="input_category" placeholder="Select or type category..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        <datalist id="client_categories">
                            <option value="Residential">
                            <option value="Commercial">
                            <option value="Government">
                            <option value="Industrial">
                            <option value="Corporate">
                            <option value="Retail">
                        </datalist>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Pricing</label>
                        <input type="text" name="pricing" id="input_pricing" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact No.</label>
                        <input type="text" name="contact_no" id="input_contact_no" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Person</label>
                        <input type="text" name="contact_person" id="input_contact_person" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Position / Dept</label>
                        <input type="text" name="position_dept" id="input_position_dept" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input type="email" name="email" id="input_email" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Location</label>
                        <input type="text" name="location" id="input_location" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Items & Inclusions</label>
                        <input type="text" name="items_inclusions" id="input_items_inclusions" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Quotation (Link URL)</label>
                        <input type="text" name="quotation" id="input_quotation" placeholder="https://..." class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Remarks (Optional)</label>
                        <input type="text" name="remarks" id="input_remarks" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeClientModal()" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" id="modal-submit-btn" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Client</button>
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
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Import Clients from Excel</h3>
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('client.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Select Excel File (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-slate-400 dark:file:bg-slate-700 dark:file:text-slate-300">
                    <p class="mt-2 text-xs text-slate-500">Ensure the file has headers: company, status, category, pricing, items_inclusions, contact_person, position_dept, contact_no, email, location, quotation, remarks.</p>
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
            <h3 class="mb-2 text-lg font-bold text-slate-900 dark:text-white">Delete Client</h3>
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
    const clientUrl = "{{ route('client.index') }}";
    
    function openAddModal() {
        document.getElementById('modal-title').textContent = 'Add New Client';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('client-form').action = clientUrl;
        
        document.getElementById('input_company').value = '';
        document.getElementById('input_status').value = '';
        document.getElementById('input_category').value = '';
        document.getElementById('input_pricing').value = '';
        document.getElementById('input_items_inclusions').value = '';
        document.getElementById('input_contact_person').value = '';
        document.getElementById('input_position_dept').value = '';
        document.getElementById('input_contact_no').value = '';
        document.getElementById('input_email').value = '';
        document.getElementById('input_location').value = '';
        document.getElementById('input_quotation').value = '';
        document.getElementById('input_remarks').value = '';
        
        document.getElementById('modal-submit-btn').textContent = 'Save Client';
        document.getElementById('client-modal').classList.remove('hidden');
    }

    function openEditModal(item) {
        document.getElementById('modal-title').textContent = 'Edit Client: ' + item.company;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('client-form').action = clientUrl + '/' + item.id;
        
        document.getElementById('input_company').value = item.company;
        document.getElementById('input_status').value = item.status || '';
        document.getElementById('input_category').value = item.category || '';
        document.getElementById('input_pricing').value = item.pricing || '';
        document.getElementById('input_items_inclusions').value = item.items_inclusions || '';
        document.getElementById('input_contact_person').value = item.contact_person || '';
        document.getElementById('input_position_dept').value = item.position_dept || '';
        document.getElementById('input_contact_no').value = item.contact_no || '';
        document.getElementById('input_email').value = item.email || '';
        document.getElementById('input_location').value = item.location || '';
        document.getElementById('input_quotation').value = item.quotation || '';
        document.getElementById('input_remarks').value = item.remarks || '';
        
        document.getElementById('modal-submit-btn').textContent = 'Update Client';
        document.getElementById('client-modal').classList.remove('hidden');
    }

    function closeClientModal() {
        document.getElementById('client-modal').classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-item-name').textContent = name;
        document.getElementById('delete-form').action = clientUrl + '/' + id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function updateInlineStatus(selectElement, id, type) {
        selectElement.disabled = true;
        
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
