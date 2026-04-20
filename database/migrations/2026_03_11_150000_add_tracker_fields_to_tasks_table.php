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
            $table->string('task_no')->nullable()->after('id');
            $table->string('specific_process')->nullable()->after('task_process');
            $table->unsignedSmallInteger('sla_days')->nullable()->after('specific_process');
            $table->string('document_link', 2048)->nullable()->after('deliverables');

            $table->index('task_no');
            $table->index('specific_process');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['task_no']);
            $table->dropIndex(['specific_process']);
            $table->dropColumn(['task_no', 'specific_process', 'sla_days', 'document_link']);
        });
    }
};
