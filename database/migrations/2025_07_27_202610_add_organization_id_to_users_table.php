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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom organization_id sebagai foreign key
            // nullable() agar Super Admin tidak perlu memiliki organisasi
            // after('password') menempatkan kolom setelah kolom 'password'
            $table->foreignId('organization_id')
                  ->nullable()
                  ->after('password')
                  ->constrained('organizations') // Merujuk ke tabel 'organizations'
                  ->onDelete('set null'); // Jika organisasi dihapus, set organization_id di user menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropConstrainedForeignId('organization_id');
            // Kemudian hapus kolom
            $table->dropColumn('organization_id');
        });
    }
};