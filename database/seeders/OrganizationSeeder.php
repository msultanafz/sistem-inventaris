<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization; // Penting: Tambahkan baris ini

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'Informatic Drone',
            'description' => 'Organisasi yang fokus pada pengembangan teknologi drone dan robotika.',
            'code' => 'IDR'
        ]);

        Organization::create([
            'name' => 'Prodi Teknik Informatika',
            'description' => 'Program Studi Teknik Informatika di Universitas XYZ.',
            'code' => 'PTI'
        ]);

        Organization::create([
            'name' => 'Multimedia Unimal',
            'description' => 'Unit kegiatan mahasiswa yang bergerak di bidang multimedia dan kreatif.',
            'code' => 'MUL'
        ]);
    }
}