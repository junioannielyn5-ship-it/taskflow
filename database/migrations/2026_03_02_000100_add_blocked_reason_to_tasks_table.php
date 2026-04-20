<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('tasks', 'blocked_reason')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->text('blocked_reason')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tasks', 'blocked_reason')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('blocked_reason');
            });
        }
    }
};
