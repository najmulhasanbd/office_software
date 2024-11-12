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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique(8);
            $table->string('name', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->text('amount'); // Store as JSON
            $table->longText('purpose'); // Store as JSON
            $table->timestamps();
        });        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
