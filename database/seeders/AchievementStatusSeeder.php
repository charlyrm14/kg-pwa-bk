<?php

namespace Database\Seeders;

use App\Models\AchievementStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'Bloqueado', 'description' => 'El logro aún no está disponible o el usuario no ha comenzado el progreso.'],
            ['id' => 2, 'name' => 'En progreso', 'description' => 'El usuario ha iniciado el progreso y está cumpliendo parcialmente los criterios.'],
            ['id' => 3, 'name' => 'Completado', 'description' => 'El usuario ha cumplido todos los requisitos y el logro está listo para ser reclamado.'],
            ['id' => 4, 'name' => 'Reclamado', 'description' => 'El usuario ha reclamado exitosamente la recompensa asociada al logro.'],
            ['id' => 5, 'name' => 'Restablecido', 'description' => 'El logro fue completado y se ha restablecido para su obtención futura (solo para logros recurrentes).'],
        ];

        AchievementStatus::upsert($statuses, ['id'], ['name', 'description']);
    }
}
