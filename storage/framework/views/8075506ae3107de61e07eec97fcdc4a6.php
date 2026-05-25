<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Inventory Items Master</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your inventory, import from Excel, or export data.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </button>
            <a href="<?php echo e(route('inventory.export')); ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export
            </a>
            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Item
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-800 dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800 overflow-hidden">
        <div class="border-b border-slate-200 dark:border-slate-700 p-4">
            <form action="<?php echo e(route('inventory.index')); ?>" method="GET" class="flex gap-2 max-w-md">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search Item Code or Description..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 pl-9 pr-4 py-2 text-sm text-slate-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>
                <button type="submit" class="rounded-xl bg-slate-100 dark:bg-slate-700 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600">Search</button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('inventory.index')); ?>" class="rounded-xl px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:bg-slate-700/50 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Unit</th>
                        <th class="px-6 py-4">Qty</th>
                        <th class="px-6 py-4">Acquired</th>
                        <th class="px-6 py-4">Distributed</th>
                        <th class="px-6 py-4">Remaining</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Brand</th>
                        <th class="px-6 py-4">Remarks</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white"><?php echo e($item->name); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->category); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->unit); ?></td>
                            <td class="px-6 py-4 font-medium"><?php echo e($item->quantity); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->quantity_acquired); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->quantity_distributed); ?></td>
                            <td class="px-6 py-4 font-medium <?php echo e($item->quantity_remaining <= 0 ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400'); ?>"><?php echo e($item->quantity_remaining); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->supplier); ?></td>
                            <td class="px-6 py-4"><?php echo e($item->brand); ?></td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400"><?php echo e($item->remarks ?? '-'); ?></td>
                            <td class="px-6 py-4 text-right">
                                <button type="button" onclick="openEditModal(<?php echo e($item->toJson()); ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3">Edit</button>
                                <button type="button" onclick="openDeleteModal(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->name)); ?>')" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                No items found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($items->hasPages()): ?>
            <div class="border-t border-slate-200 dark:border-slate-700 p-4">
                <?php echo e($items->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('modals'); ?>
<div id="item-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add New Item</h3>
                <button type="button" onclick="closeItemModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="item-form" method="POST" action="<?php echo e(route('inventory.store')); ?>">
                <?php echo csrf_field(); ?>
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
            <form method="POST" action="<?php echo e(route('inventory.import')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inventoryUrl = "<?php echo e(route('inventory.index')); ?>";
    
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\inventory\index.blade.php ENDPATH**/ ?>