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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['parcel', 'pier'])->default('parcel');
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('set null');
            $table->foreignId('area_id')->constrained('areas')->cascadeOnDelete();
            $table->string('num')->nullable();
            $table->string('old_num')->nullable();
            $table->float('size_m2')->nullable();
            $table->date('evi_start');  // evidence start date
            $table->date('evi_end')->nullable();  // evidence end date
            $table->text('evi_end_rsn')->nullable();  // evidence end reason
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
