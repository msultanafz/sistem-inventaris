<?php

namespace Database\Seeders;

use App\Models\User; // Penting: Pastikan ini ada
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Penting: Tambahkan baris ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan ada User yang akan Anda gunakan untuk login Super Admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@super.inventaris', 
            'password' => Hash::make('12131415'), 
        ]);

        $this->call(OrganizationSeeder::class);
    }
}