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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('status')->nullable();
            $table->string('category')->nullable();
            $table->string('pricing')->nullable();
            $table->string('items_inclusions')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('position_dept')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->text('quotation')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
