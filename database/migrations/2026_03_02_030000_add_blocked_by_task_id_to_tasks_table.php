<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('blocked_by_task_id')
                ->nullable()
                ->after('done_at')
                ->constrained('tasks')
                ->nullOnDelete();

            $table->index('blocked_by_task_id');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['blocked_by_task_id']);
            $table->dropConstrainedForeignId('blocked_by_task_id');
        });
    }
};
