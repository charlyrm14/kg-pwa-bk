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
        ProgressStatus::updateOrCreate([
            'slug' => 'en-progreso'
        ], [
            'name' => 'En progreso', 
            'slug' => 'en-progreso',
            'description' => 'Nivel en progreso'
        ]);

        ProgressStatus::updateOrCreate([
            'slug' => 'pendiente'
        ], [
            'name' => 'Pendiente', 
            'slug' => 'pendiente',
            'description' => 'Nivel pendiente'
        ]);

        ProgressStatus::updateOrCreate([
            'slug' => 'completado'
        ], [
            'name' => 'Completado', 
            'slug' => 'completado',
            'description' => 'Nivel completado'
        ]);
    }
}
