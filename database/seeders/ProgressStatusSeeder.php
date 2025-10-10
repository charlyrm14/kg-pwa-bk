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
            ['id' => 1, 'name' => 'IN PROGRESS', 'slug' => 'IN-PROGRESS', 'description' => 'Nivel en progreso'],
            ['id' => 2, 'name' => 'PENDING', 'slug' => 'PENDING', 'description' => 'Nivel pendiente de completar'],
            ['id' => 3, 'name' => 'COMPLETED', 'slug' => 'COMPLETED', 'description' => 'Nivel Completado']
        ];

        ProgressStatus::upsert($progress, ['id'], ['name', 'slug', 'description']);
    }
}
