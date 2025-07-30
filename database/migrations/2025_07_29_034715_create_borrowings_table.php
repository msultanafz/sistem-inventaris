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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('cascade');
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade'); // Untuk scope organisasi
            $table->string('borrower_name'); // Nama peminjam
            $table->string('borrower_contact')->nullable(); // Kontak peminjam (misal: email, no HP, NIM/NIP)
            $table->string('borrower_nim_nip')->nullable(); // NIM/NIP peminjam
            $table->integer('quantity'); // Jumlah barang yang dipinjam
            $table->timestamp('borrow_date'); // Tanggal peminjaman
            $table->timestamp('due_date')->nullable(); // Tanggal jatuh tempo (opsional, untuk notifikasi)
            $table->timestamp('return_date')->nullable(); // Tanggal pengembalian (nullable karena belum tentu dikembalikan)
            $table->string('status')->default('borrowed'); // Status: borrowed, returned, overdue, cancelled

            // Kolom untuk menyimpan foto sebagai Base64
            $table->longText('borrow_photo')->nullable(); // Foto saat peminjaman (Base64 string)
            $table->longText('return_photo')->nullable(); // Foto saat pengembalian (Base64 string)

            $table->text('notes')->nullable(); // Catatan tambahan untuk peminjaman

            // Siapa yang melakukan transaksi (user ID dari tabel users)
            $table->foreignId('borrowed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('returned_by')->nullable()->constrained('users')->onDelete('set null'); // Siapa yang mengembalikan

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};