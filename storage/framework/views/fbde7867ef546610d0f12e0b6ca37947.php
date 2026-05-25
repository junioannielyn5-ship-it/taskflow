<div>
    <div class="flex items-center gap-2">
        <?php if($running): ?>
            <button wire:click="stopTimer" class="bg-red-500 text-white px-3 py-1 rounded">Stop Timer</button>
            <span class="font-mono text-lg"><?php echo e(gmdate('H:i:s', $duration)); ?></span>
        <?php else: ?>
            <button wire:click="startTimer" class="bg-green-500 text-white px-3 py-1 rounded">Start Timer</button>
            <span class="font-mono text-lg"><?php echo e(gmdate('H:i:s', $duration)); ?></span>
        <?php endif; ?>
    </div>
</div>
<script>
    // Optionally, poll every second for real-time updates
    setInterval(function() {
        @this.fetchActiveLog();
    }, 1000);
</script>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\livewire\task-timer.blade.php ENDPATH**/ ?>