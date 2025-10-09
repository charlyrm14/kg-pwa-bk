<?php

namespace Database\Seeders;

use App\Models\AttendanceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'PRESENT', 'description' => 'El alumno o participante asistió a la sesión.'],
            ['id' => 2, 'name' => 'ABSENT_UNJUSTIFIED', 'description' => 'Ausencia sin previo aviso ni justificación.'],
            ['id' => 3, 'name' => 'ABSENT_JUSTIFIED', 'description' => 'Ausencia justificada (ej. enfermedad, cita médica).'],
            ['id' => 4, 'name' => 'LATE', 'description' => 'El alumno llegó tarde.'],
            ['id' => 5, 'name' => 'EXCUSED', 'description' => 'Exento de asistir por parte del entrenador (ej. lesión, descanso).'],
        ];

        AttendanceStatus::upsert($statuses, ['id'], ['name', 'description']);
    }
}
