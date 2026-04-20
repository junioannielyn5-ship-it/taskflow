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
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('task_process')->nullable()->after('description');
            $table->string('company')->nullable()->after('task_process');
            $table->date('date_received')->nullable()->after('priority');
            $table->date('date_started')->nullable()->after('date_received');

            $table->index('company');
            $table->index('date_received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['company']);
            $table->dropIndex(['date_received']);
            $table->dropColumn(['task_process', 'company', 'date_received', 'date_started']);
        });
    }
};
