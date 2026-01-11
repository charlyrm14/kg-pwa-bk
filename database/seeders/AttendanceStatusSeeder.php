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
            ['id' => 1, 'name' => 'Asistió', 'description' => 'El alumno o participante asistió a la sesión.'],
            ['id' => 2, 'name' => 'Ausencia no justificada', 'description' => 'Ausencia sin previo aviso ni justificación.'],
            ['id' => 3, 'name' => 'Ausencia justificada', 'description' => 'Ausencia justificada (ej. enfermedad, cita médica).'],
            ['id' => 4, 'name' => 'Retardo', 'description' => 'El alumno llegó tarde.'],
            ['id' => 5, 'name' => 'Exento', 'description' => 'Exento de asistir por parte del entrenador (ej. lesión, descanso).'],
            ['id' => 6, 'name' => 'No asignado', 'description' => 'Día no asignado como asistencia.'],
        ];

        AttendanceStatus::upsert($statuses, ['id'], ['name', 'description']);
    }
}
