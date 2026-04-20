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
            $table->string('team_in_charge')->nullable()->after('company');
            $table->string('deliverables')->nullable()->after('team_in_charge');
            $table->text('remarks')->nullable()->after('deliverables');

            $table->index('team_in_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['team_in_charge']);
            $table->dropColumn(['team_in_charge', 'deliverables', 'remarks']);
        });
    }
};
