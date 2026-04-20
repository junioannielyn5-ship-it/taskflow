<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('task_process_options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('task_team_options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('task_companies')->insert([
            ['name' => 'PBI', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Toyota', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Splash', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('task_process_options')->insert([
            ['name' => 'For Support', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'For Quote', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Endorsed', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('task_team_options')->insert([
            ['name' => 'Technical', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sales', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pre-sales', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('system_settings')->insert([
            'key' => 'system_announcement',
            'value' => 'Manual spreadsheet tracking is now transitioned to a centralized workflow with live status visibility, Kanban execution, and automated daily reports.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('task_team_options');
        Schema::dropIfExists('task_process_options');
        Schema::dropIfExists('task_companies');
    }
};
