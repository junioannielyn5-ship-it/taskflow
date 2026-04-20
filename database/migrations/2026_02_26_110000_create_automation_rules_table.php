<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('trigger_event');
            $table->json('conditions')->nullable();
            $table->json('actions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('trigger_event');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_rules');
    }
};
