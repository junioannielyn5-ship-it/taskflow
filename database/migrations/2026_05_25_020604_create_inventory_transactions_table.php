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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('cascade');
            $table->enum('type', ['move_in', 'stock_out', 'correction']);
            $table->integer('quantity'); // Positive integer representing the magnitude of the change
            $table->date('transaction_date');
            
            // For Stock Out (dispatch) linking
            $table->string('reference')->nullable(); // e.g. "Project A", "Client B", or receipt number
            
            $table->text('remarks')->nullable();
            
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
