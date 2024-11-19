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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->string('number')->unique();
            $table->decimal('bail', 10, 2);
            $table->decimal('yearly_fee', 10, 2);
            $table->unsignedSmallInteger('tax')->default(20);
            $table->unsignedSmallInteger('pay_term')->default(15);
            $table->date('start_date');  // start of contract
            $table->date('length')->nullable();  // length of contract
            $table->date('end_date')->nullable();  // end of contract

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
