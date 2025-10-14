<?php

namespace Database\Seeders;

use App\Models\ProgressStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgressStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $progress = [
            ['id' => 1, 'name' => 'ACTIVE', 'slug' => 'ACTIVE', 'description' => 'Progreso activo y en curso'],
            ['id' => 2, 'name' => 'COMPLETED', 'slug' => 'COMPLETED', 'description' => 'Progreso completado (100%).'],
            ['id' => 3, 'name' => 'PAUSED', 'slug' => 'PAUSED', 'description' => 'Progreso temporalmente detenido.']
        ];

        ProgressStatus::upsert($progress, ['id'], ['name', 'slug', 'description']);
    }
}
