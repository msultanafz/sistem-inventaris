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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel organizations
            $table->foreignId('organization_id')
                  ->constrained('organizations')
                  ->onDelete('cascade'); // Jika organisasi dihapus, barangnya juga dihapus

            $table->string('name');
            $table->string('code')->nullable()->unique(); // Kode boleh kosong, unik
            $table->string('category');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->string('unit', 50); // Misalnya: pcs, unit, box, dll.
            $table->string('condition')->default('Baik'); // Misalnya: Baik, Rusak Ringan, Rusak Berat, Perlu Perbaikan
            $table->string('location');
            $table->date('purchase_date')->nullable();
            $table->text('notes')->nullable();

            // Foreign keys untuk created_by dan updated_by
            $table->foreignId('created_by')
                  ->nullable() // Boleh null jika user dihapus
                  ->constrained('users')
                  ->onDelete('set null');
            $table->foreignId('updated_by')
                  ->nullable() // Boleh null jika user dihapus
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
